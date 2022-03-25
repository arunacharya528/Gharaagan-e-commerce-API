<?php

namespace App\Http\Controllers;

use App\Models\ShoppingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShoppingSessionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $session = ShoppingSession::get();
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
        $session = ShoppingSession::with('cartItems.product.images')->find($shoppingSession->id);
        // checks and sees if the given session belongs to authorised user
        if ($session->user->id !== Auth::user()->id) {
            return redirect()->route('unauthorized');
        }
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
}
