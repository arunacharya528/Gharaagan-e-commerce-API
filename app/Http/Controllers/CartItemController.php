<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductInventory;
use App\Models\ShoppingSession;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $item = CartItem::get();
        // return response()->json($item);
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
        if (Auth::user()->role !== 3) {
            return redirect()->route('unauthorized');
        }

        $item  = CartItem::where(['product_id' => $request->product_id, 'session_id' => $request->session_id, 'inventory_id' => $request->inventory_id]);
        if ($item->exists()) {
            $item = $item->first();
            $item->quantity = $request->quantity +  $item->quantity;
            $item->save();
        } else {
            $item = CartItem::create($request->all());
        }
        return response()->json($item);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function show(CartItem $cartItem)
    {
        // $item = CartItem::find($cartItem->id);
        // return response()->json($item);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function edit(CartItem $cartItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CartItem $cartItem)
    {
        if (Auth::user()->role !== 3) {
            return redirect()->route('unauthorized');
        }

        $item = CartItem::find($cartItem->id);
        $item->update($request->all());
        return response()->json($item);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CartItem  $cartItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(CartItem $cartItem)
    {
        if (Auth::user()->role === 2) {
            return redirect()->route('unauthorized');
        }
        return CartItem::destroy($cartItem->id);
    }
}
