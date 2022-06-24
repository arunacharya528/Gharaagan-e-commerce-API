<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\Mailer;
use App\Models\CartItem;
use App\Models\Discount;
use App\Models\Email;
use App\Models\OrderDetail;
use App\Models\OrderItem;
use App\Models\ProductInventory;
use App\Models\ShoppingSession;
use App\Models\User;
use App\Models\UserAddress;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Laravel\Passport\Bridge\RefreshTokenRepository;

class AuthController extends Controller
{
    public function registerClient(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'contact' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = new User();
        $user->name = $request->name;
        $user->contact = $request->contact;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        ShoppingSession::create(['user_id' => $user->id]);
        Email::create(['email' => $user->email]);
        return response()->json($user->with('hasNewsletter'));
    }

    public function login(Request $request)
    {
        try {
            $validateUser = Validator::make(
                $request->all(),
                [
                    'email' => 'required|email',
                    'password' => 'required'
                ]
            );

            if ($validateUser->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }

            if (!Auth::attempt($request->only(['email', 'password']))) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email & Password does not match with our record.',
                ], 401);
            }

            $user = User::where('email', $request->email)->first();

            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }
    }


    public function logout(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $user->tokens()->delete();
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }


    //===============================================
    //
    //  All methods to be required in client side
    //
    //===============================================

    public function getSession()
    {
        $user =  User::with([
            'shoppingSession.cartItems.product.images.file',
            'shoppingSession.cartItems.inventory.discount',
            'shoppingSession.cartItems.product.category'
        ])->find(Auth::user()->id);
        return response()->json($user->shoppingSession);
    }

    public function getOrderDetail()
    {
        $user =  User::find(Auth::user()->id);
        return response()->json($user->orderDetails);
    }


    public function getRatings()
    {
        $user =  User::with([
            'productRatings' => function ($query) {
                $query->with('product')->orderBy('created_at', 'desc');
            },
        ])->find(Auth::user()->id);
        return response()->json($user->productRatings);
    }

    public function getQuestionAnswers()
    {
        $user =  User::with([
            'questionAnswers' => function ($query) {
                $query->with('product')->orderBy('created_at', 'desc');
            }
        ])->find(Auth::user()->id);
        return response()->json($user->questionAnswers);
    }

    public function getAddresses()
    {
        $user =  User::with([
            'addresses.delivery'
        ])->find(Auth::user()->id);
        return response()->json($user->addresses);
    }

    public function getWishList()
    {
        $user =  User::with([
            'wishlist.product' => function ($query) {
                return $query->with(
                    'category',
                    'inventories.discount',
                    'images.file',
                    'brand'
                )->withAvg('ratings', 'rate');
            }
        ])->find(Auth::user()->id);
        return response()->json($user->wishlist);
    }


    public function checkout(Request $request)
    {
        DB::beginTransaction();
        $priceAfterDiscount = function ($price, $discount) {
            if ($discount === null || $discount->active === 0) {
                return $price;
            } else {
                return $price - (0.01 * $discount->discount_percent * $price);
            }
        };
        try {
            $session = ShoppingSession::where('user_id', Auth::user()->id)->first();

            if (!$request->exists('address_id')) {
                throw new Exception('Address is required');
            }

            $discount_id = null;
            if ($request->exists('discount_id')) {
                $discount_id = $request->input('discount_id');
            }

            $order = OrderDetail::create([
                'user_id' => Auth::user()->id,
                'address_id' => $request->input('address_id'),
                'discount_id' => $request->input('discount_id'),
                'total' => 0
            ]);


            $total = 0;
            foreach ($session->cartItems as $item) {

                // add price after discount in each loop to total
                $inventory = ProductInventory::with('discount')->find($item->inventory_id);
                $total += $priceAfterDiscount($inventory->price, $inventory->discount) * $item->quantity;

                if ($inventory->quantity > $item->quantity) {

                    // create order item
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'inventory_id' => $item->inventory_id,
                        'quantity' => $item->quantity
                    ]);

                    // updating quantity of product in inventory
                    $inventory->quantity = $inventory->quantity - $item->quantity;
                    $inventory->save();
                } else {
                    throw new Exception("Requested quantity of $item->product is unavailable.");
                }
            }

            // get discounted price of order
            $discount = Discount::find($discount_id);
            $total = $priceAfterDiscount($total, $discount);

            // get delivery price
            $address = UserAddress::with('delivery')->find($request->input('address_id'));
            $total += $address->delivery->price;

            // save total price
            $order->total = $total;
            $order->status = 1;
            $order->save();

            // delete all cart items
            CartItem::where('session_id', $session->id)->delete();

            $pdf = Pdf::loadView('invoice', ['orderDetail' => $order])->setPaper('a4', 'landscape');

            $subject = 'Gharagan Invoice of order #' . $order->id;
            $body = "Invoice of gharagan order. The content of this bill may change over time. It is advised to keep this mail as a proop of purchase in this site.";
            $mailable = new Mailer($subject, $body);
            $mailable->setAttachment($pdf->output(), 'demo.pdf', [
                'mime' => 'application/pdf',
            ]);
            Mail::to("acharyaumesh742@gmail.com")->send($mailable);
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
        DB::commit();
        return response()->json($order);
    }
}
