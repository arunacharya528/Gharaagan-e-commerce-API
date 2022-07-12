<?php

namespace App\Http\Controllers;

use App\Models\ProductRating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductRatingController extends Controller
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

        $rating = ProductRating::with([
            'user', 'product', 'orderDetail'
        ])->orderBy('created_at', 'desc')->get();
        return response()->json($rating);
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
        $request['user_id'] = Auth::user()->id;
        $rating = ProductRating::create($request->all());
        return response()->json($rating);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductRating  $productRating
     * @return \Illuminate\Http\Response
     */
    public function show(ProductRating $productRating)
    {
        // $rating = ProductRating::find($productRating->id);
        // return response()->json($rating);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductRating  $productRating
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductRating $productRating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductRating  $productRating
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductRating $productRating)
    {
        // $rating = ProductRating::find($productRating->id);
        // $rating->update($request->all());
        // return response()->json($rating);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductRating  $productRating
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductRating $productRating)
    {
        if (Auth::user()->role === 3 && $productRating->user_id !== Auth::user()->id) {
            return redirect()->route('unauthorized');
        }
        return ProductRating::destroy($productRating->id);
    }


    // public function hasRated(Request $request)
    // {
    //     if (!$request->exists('user_id') || !$request->exists('product_id')) {
    //         return response()->json("User id and product id required", 500);
    //     }
    //     $rated = ProductRating::where([
    //         'user_id' => $request->input('user_id'),
    //         'product_id' => $request->input('product_id')

    //     ])->exists();

    //     if ($rated) {
    //         return response()->json("Found");
    //     } else {
    //         return response()->json("Not Found", 204);
    //     }
    // }
}
