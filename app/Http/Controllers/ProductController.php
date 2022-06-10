<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // $this->middleware("auth:api")->only(["store", "update", 'destroy']);
    }

    //=========================================
    //
    //       Methods for admin section
    //
    //=========================================
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::with([
            'category',
            'inventories',
            'images',
            'ratings',
            'brand'
        ])
            ->get();
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
        $request['SKU'] = Str::uuid();
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
        $product = Product::with([
            'category.parent.childCategories',
            'inventories.discount',
            'ratings.user',
            'images.file',
            'brand',
            'questionAnswers' => function ($query) {
                $query->with('user')->orderBy('created_at', 'desc');
            }
        ])
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


    //=========================================
    //
    //       Methods for client section
    //
    //=========================================

    public function getAll(Request $request)
    {


        $mode = $request->input('mode');
        $order = $request->input('orderBy') === 'desc' ? 'desc' : 'asc';
        $withArray = [
            'category',
            'inventories.discount',
            'images.file',
            'brand'
        ];

        $sortByPrice = function ($instance) use ($request) {
            return $instance = $instance->with(['inventories' => function ($query) use ($request) {
                $data = $query;

                if ($request->exists('pmin')) {
                    $data = $data->where('price', '>=', (int) $request->input('pmin'));
                }

                if ($request->exists('pmax')) {
                    $data = $data->where('price', '<=', (int) $request->input('pmax'));
                }

                $data->orderBy('price', 'desc');

                return $data;
            }]);
        };

        if ($mode === 'related') {
            // get related product where parent category id is same
            if (!$request->exists('product_id')) {
                return response()->json(['include product_id'], 500);
            }
            $categories = Product::where('id', $request->input('product_id'))->with(
                [
                    'category.parent.category'
                ]
            )->first()->category->parent->category->pluck('id');

            $products = Product::whereIn('category_id', $categories->toArray())->with($withArray);
            $products = $sortByPrice($products);
            $products = $products->withAvg('ratings', 'rate')->orderBy('ratings_avg_rate', 'desc');
            $this->allProducts = $products->get();
        } else {
            $products = new Product();

            $products = $products->with($withArray);
            $products = $products->withAvg('ratings', 'rate');


            // for sorting by price
            $products = $sortByPrice($products);

            // filter by name
            if ($request->exists('name')) {
                $products = $products->where('name', 'like', "%" . $request->input('name') . "%");
            }

            // sort by brand
            if ($request->exists('brands')) {
                $brands = explode(",", $request->input('brands'));
                foreach ($brands as $brand) {
                    $products = $products->orWhere('brand_id', '=', (int) $brand);
                }
            }

            // sort by category
            if ($request->exists('categories')) {
                $categories = explode(",", $request->input('categories'));
                foreach ($categories as $category) {
                    $products = $products->orWhere('category_id', '=', (int) $category);
                }
            }

            // sort by latest
            if ($request->input('sort') === 'latest') {
                $products = $products->orderBy('created_at', $order);
            }

            // sort by the product that has most ratings
            if ($request->input('sort') === 'controversial') {
                $products = $products->withCount('ratings')->orderBy('ratings_count', $order);
            }

            //sort by product that is most added to the wishlist
            if ($request->input('sort') === 'popular') {
                $products = $products->withCount('wishList')->orderBy('wish_list_count', $order);
            }

            // sort by average rating of the product
            if ($request->input('sort') === 'rating') {
                $products->orderBy('ratings_avg_rate', $order);
            }

            $this->allProducts = $products->get();
        }

        return response()->json($this->allProducts);
    }
}
