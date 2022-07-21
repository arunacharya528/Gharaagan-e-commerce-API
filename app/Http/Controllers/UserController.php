<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role !== 1) {
            return redirect()->route('unauthorized');
        }
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
        if (Auth::user()->role !== 1) {
            return redirect()->route('unauthorized');
        }
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
        if (Auth::user()->role !== 1) {
            return redirect()->route('unauthorized');
        }
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
            'questionAnswers' => function ($query) {
                $query->with(['product', 'user'])->orderBy('created_at', 'desc');
            }

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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (Auth::user()->role !== 1 || $user->role === 1) {
            return redirect()->route('unauthorized');
        }
        return User::destroy($user->id);
    }
}
