<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->middleware("auth:api")->only(["store", "update", 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $brands = explode(",", $request->input('brands'));
        $categories = explode(",", $request->input('categories'));
        $itemsPerPage = (int) $request->input('item');
        $pageNumber = (int) $request->input('page');

        $products = Product::with([
            'category',
            'discount',
            'images',
            'ratings',
            'brand'
        ]);

        if ($request->input('pmin') !== null) {
            $products = $products->where('price', '>', (int)$request->input('pmin'));
        }

        if ($request->input('pmax') !== null) {
            $products = $products->where('price', '<', (int) $request->input('pmax'));
        }

        if ($request->input('brands') !== null) {
            foreach ($brands as $brand) {
                $products = $products->orWhere('brand_id', '=', (int) $brand);
            }
        }
        if ($request->input('categories') !== null) {
            foreach ($categories as $category) {
                $products = $products->orWhere('category_id', '=', (int) $category);
            }
        }

        if ($request->input('sort') == 'mostViewed') {
            $products = $products->orderBy('views', "desc");
        }
        if ($request->input('sort') == 'latest') {
            $products = $products->orderBy('created_at', "desc");
        }
        $products =  $products->paginate($itemsPerPage, ['*'], 'page', $pageNumber);

        // gettting average rating of all products
        // loop with all components and append value to the respective sub-array
        foreach ($products as $product) {
            $product['averageRating'] = $product->ratings->avg('rate');
            // delete rating array to freeup space in frontend
            unset($product['ratings']);
        }

        return response()->json($products);
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
        $product = Product::create($request->all());
        return response()->json($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $product = Product::with('category.parent.childCategories')
            ->with('inventories')
            ->with('discount')
            ->with('ratings.user')
            ->with('images')
            ->with('brand')
            ->with('questions.answers')
            ->with('questions.user')
            ->find($product->id);
        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $product = Product::find($product->id);
        $product->update($request->all());
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        return Product::destroy($product->id);
    }
}
