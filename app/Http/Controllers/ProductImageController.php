<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductImageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->role === 3) {
            return redirect()->route('unauthorized');
        }
        $images = ProductImage::with('file');
        if ($request->input('product_id') !== null) {
            $images = $images->where('product_id', $request->input('product_id'))->get();
        } else {
            $images = $images->get();
        }
        return response()->json($images);
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
        $image = ProductImage::create($request->all());
        return response()->json($image);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function show(ProductImage $productImage)
    {
        // $image = ProductImage::find($productImage->id);
        // return response()->json($image);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductImage $productImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductImage $productImage)
    {
        // $image = ProductImage::find($productImage->id);
        // $image->update($request->all());
        // return response()->json($image);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductImage  $productImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductImage $productImage)
    {
        if (Auth::user()->role === 3) {
            return redirect()->route('unauthorized');
        }
        return ProductImage::destroy($productImage->id);
    }
}
