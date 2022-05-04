<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Discount;
use App\Models\OrderDetail;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductInventory;
use App\Models\ShoppingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ShoppingSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session = ShoppingSession::with([
            'cartItems.product',
            'user'
        ])->orderBy('updated_at', 'desc')->get();
        return response()->json($session);
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
        $session = ShoppingSession::create($request->all());
        return response()->json($session);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShoppingSession  $shoppingSession
     * @return \Illuminate\Http\Response
     */
    public function show(ShoppingSession $shoppingSession)
    {
        evaluate($shoppingSession->id);
        $session = ShoppingSession::with('cartItems.product.images.file')
            ->with('cartItems.inventory.discount')
            ->with('cartItems.product.category')
            ->with('cartItems.product.brand')
            ->find($shoppingSession->id);
        // checks and sees if the given session belongs to authorised user
        // if ($session->user->id !== Auth::user()->id) {
        //     return redirect()->route('unauthorized');
        // }
        return response()->json($session);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ShoppingSession  $shoppingSession
     * @return \Illuminate\Http\Response
     */
    public function edit(ShoppingSession $shoppingSession)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShoppingSession  $shoppingSession
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ShoppingSession $shoppingSession)
    {
        $session = ShoppingSession::find($shoppingSession->id);
        $session->update($request->all());
        return response()->json($session);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShoppingSession  $shoppingSession
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingSession $shoppingSession)
    {
        return ShoppingSession::destroy($shoppingSession->id);
    }


    /**
     * Create order with the session data
     */

    public function createOrder($session_id, Request $request)
    {
        // checks and sees if the given session belongs to authorised user
        if (ShoppingSession::find($session_id)->user->id !== Auth::user()->id) {
            return redirect()->route('unauthorized');
        }

        DB::beginTransaction();
        $message = [];
        try {
            evaluate($session_id);

            $session = ShoppingSession::with('cartItems')->find($session_id);

            // find by discount name and apply discount
            $discount = null;
            if ($request->discountName !== null) {
                $discount = Discount::where(['name' => $request->discountName])->first();
            }

            $discountedPrice = $request->discountName !== null ? $session->total - (0.01 * $discount->discount_percent * $session->total) : $session->total;


            // Create an order detail
            $order = OrderDetail::create([
                'user_id' => $session->user->id,
                'total' => $discountedPrice,
                'discount_id' => $request->discountName == null ? null : $discount->id
            ]);

            // for all cart item add them to order item following order detail
            foreach ($session->cartItems as $item) {
                // create order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'inventory_id' => $item->inventory_id,
                    'quantity' => $item->quantity
                ]);

                // updating quantity of product in inventory
                $inventory = ProductInventory::find($item->inventory_id);
                $inventory->quantity = $inventory->quantity - $item->quantity;
                $inventory->save();
            }

            // delete all cart items
            CartItem::where('session_id', $session_id)->delete();
        } catch (\Throwable $th) {
            error_log($th->getMessage());
            DB::rollBack();
            return response()->json(['error' => "There was problem creating order"], 500);
        }
        DB::commit();

        return response()->json(['success' => "Order created successfully"], 200);
    }
}
