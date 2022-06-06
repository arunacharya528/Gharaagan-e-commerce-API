<?php

namespace App\Http\Controllers;

use App\Mail\Mailer;
use App\Models\CartItem;
use App\Models\Discount;
use App\Models\OrderDetail;
use App\Models\OrderItem;
use App\Models\ProductInventory;
use App\Models\ShoppingSession;
use App\Models\User;
use App\Models\UserAddress;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = User::get();
        return response()->json($user);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = User::create($request->all());
        return response()->json($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        // if ($user->id !== Auth::user()->id) {
        //     return redirect()->route('unauthorized');
        // }
        $user = User::with([
            'shoppingSession.cartItems.product.images.file',
            'shoppingSession.cartItems.inventory.discount',
            'shoppingSession.user',
            'orderDetails.orderItems.product',
            'orderDetails.orderItems.inventory.discount',
            'orderDetails.user',
            'orderDetails.address',
            'orderDetails.discount',
            'productRatings.product',
            'productRatings.user',
            'productRatings.orderDetail',
            'questionAnswers.answers',
            'questionAnswers.user',
            'questionAnswers.product'

        ])->where('id', $user->id)->first();
        return response()->json($user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        if ($user->id !== Auth::user()->id) {
            return redirect()->route('unauthorized');
        }

        $user = User::find($user->id);

        $rule = [];

        if ($request->first_name !== null || $request->last_name !== null || $request->contact !== null) {
            $rule['first_name'] = 'required';
            $rule['last_name'] = 'required';
            $rule['contact'] = 'required';
        }

        if ($request->email !== null) {
            $rule['email'] = 'email:rfc,dns|unique:users,email,' . $user->id;
        }

        if ($request->password !== null || $request->password_confirmation !== null) {
            $rule['password'] = ['required', 'confirmed', Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised()];
        }

        $validator = Validator::make($request->all(), $rule);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        try {
            $user->update($request->all());
        } catch (\Throwable $th) {
            return response()->json([['message' => 'Given fields must be filled']], 400);
        }
        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        return User::destroy($user->id);
    }


    //===============================================
    //
    //      All methods to be required in client side
    //
    //===============================================

    public function getSession(User $user)
    {
        $user =  User::with([
            'shoppingSession.cartItems.product.images.file',
            'shoppingSession.cartItems.inventory.discount',
            'shoppingSession.cartItems.product.category'
        ])->find($user->id);
        return response()->json($user->shoppingSession);
    }

    public function getOrderDetail(User $user)
    {
        $user =  User::find($user->id);
        return response()->json($user->orderDetails);
    }


    public function getRatings(User $user)
    {
        $user =  User::with([
            'productRatings' => function ($query) {
                $query->with('product')->orderBy('created_at', 'desc');
            },
        ])->find($user->id);
        return response()->json($user->productRatings);
    }

    public function getQuestionAnswers(User $user)
    {
        $user =  User::with([
            'questionAnswers.answers',
            'questionAnswers.product',
        ])->find($user->id);
        return response()->json($user->questionAnswers);
    }

    public function getAddresses(User $user)
    {
        $user =  User::with([
            'addresses.delivery'
        ])->find($user->id);
        return response()->json($user->addresses);
    }

    public function getWishList(User $user)
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
        ])->find($user->id);
        return response()->json($user->wishlist);
    }


    public function checkout(Request $request, User $user)
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
            $session = ShoppingSession::where('user_id', $user->id)->first();

            if (!$request->exists('address_id')) {
                throw new Exception('Address is required');
            }

            $discount_id = null;
            if ($request->exists('discount_id')) {
                $discount_id = $request->input('discount_id');
            }

            $order = OrderDetail::create([
                'user_id' => $user->id,
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

            $subject = 'Gharagan Invoice of order #' . $order->id;
            $body = "";
            Mail::to("acharyaumesh742@gmail.com")->send(new Mailer($subject, $body));

            // $pdf = PDF::loadView('pdf.invoice', $data);


        } catch (\Throwable $th) {
            error_log($th->getMessage());
            DB::rollBack();
            return response()->json(['error' => $th->getMessage()], 500);
        }
        DB::commit();
        return response()->json($order);
    }
}
