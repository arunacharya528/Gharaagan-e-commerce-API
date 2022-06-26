<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role === 3) {
            return redirect()->route('unauthorized');
        }
        $discount = Discount::get();
        return response()->json($discount);
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
        if (Auth::user()->role === 3) {
            return redirect()->route('unauthorized');
        }
        $discount = Discount::create($request->all());
        return response()->json($discount);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show(Discount $discount)
    {
        // $discount = Discount::find($discount->id);
        // return response()->json($discount);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discount $discount)
    {
        if (Auth::user()->role === 3) {
            return redirect()->route('unauthorized');
        }
        $discount = Discount::find($discount->id);
        $discount->update($request->all());
        return response()->json($discount);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        if (Auth::user()->role === 3) {
            return redirect()->route('unauthorized');
        }
        return Discount::destroy($discount->id);
    }


    public function findDiscount($discountName)
    {
        $discountByName = Discount::where(['name' => $discountName]);
        if ($discountByName->exists()) {
            return response()->json($discountByName->first());
        } else {
            return response()->json([], 404);
        }
    }
}
