<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductCategoryController extends Controller
{
    /**
     * Constructor
     */
    public function __construct()
    {
        // $this->middleware("auth:api")->only(["store", "update", 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // get nested categories with parent and child
        $categories = ProductCategory::where(['is_parent' => true])->with('childCategories')->with('products')->get();
        foreach ($categories as $category) {
            // on each category get the available number of products
            $totalProducts = 0;
            // if is parent, proceed to get the children
            if ($category->is_parent == true) {
                foreach ($category->childCategories as $childCategory) {

                    $numberOfProducts = $childCategory->products->count();
                    // on each child category get the available number of products
                    $childCategory['number_of_product'] = $numberOfProducts;
                    $totalProducts += $numberOfProducts;

                    //remove the related products to free up memory in frontend
                    unset($childCategory->products);
                }
            }
            $category['number_of_product'] = $totalProducts;
            //remove the related products to free up memory in frontend
            unset($category->products);
        }
        return response()->json($categories);
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
            return redirect(route('unauthorized'));
        } else {
            $category = ProductCategory::create($request->all());
            return response()->json($category);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $productCategory)
    {
        $productCategory = ProductCategory::find($productCategory->id);
        return response()->json($productCategory);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategory $productCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductCategory $productCategory)
    {
        if (Auth::user()->role === 3) {
            return redirect(route('unauthorized'));
        } else {
            $productCategory = ProductCategory::find($productCategory->id);
            $productCategory->update($request->all());
            return response()->json($productCategory);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        if (Auth::user()->role === 3) {
            return redirect(route('unauthorized'));
        } else {
            return ProductCategory::destroy($productCategory->id);
        }
    }
}
