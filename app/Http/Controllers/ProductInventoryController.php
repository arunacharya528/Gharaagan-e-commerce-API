<?php

namespace App\Http\Controllers;

use App\Models\ProductInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductInventoryController extends Controller
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
        $inventories = ProductInventory::with('discount');
        if ($request->input('product_id') !== null) {
            $inventories = $inventories->where('product_id', $request->input('product_id'))->get();
        } else {
            $inventories = $inventories->get();
        }

        return response()->json($inventories);
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
        $inventory = ProductInventory::create($request->all());
        return response()->json($inventory);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductInventory  $productInventory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductInventory $productInventory)
    {
        // $inventory = ProductInventory::find($productInventory->id);
        // return response()->json($inventory);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductInventory  $productInventory
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductInventory $productInventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductInventory  $productInventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductInventory $productInventory)
    {
        if (Auth::user()->role === 3) {
            return redirect()->route('unauthorized');
        }
        $inventory = ProductInventory::find($productInventory->id);
        $inventory->update($request->all());
        return response()->json($inventory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductInventory  $productInventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductInventory $productInventory)
    {
        if (Auth::user()->role === 3) {
            return redirect()->route('unauthorized');
        }
        return ProductInventory::destroy($productInventory->id);
    }
}
