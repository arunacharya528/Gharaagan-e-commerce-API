<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
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
            $category['number_of_product'] = $category->products->count();

            // if is parent, proceed to get the children
            if ($category->is_parent == true) {
                foreach ($category->childCategories as $childCategory) {

                    // on each child category get the available number of products
                    $childCategory['number_of_product'] = $childCategory->products->count();

                    //remove the related products to free up memory in frontend
                    unset($childCategory->products);
                }
            }
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
        $category = ProductCategory::create($request->all());
        return response()->json($category);
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
        $productCategory = ProductCategory::find($productCategory->id);
        $productCategory->update($request->all());
        return response()->json($productCategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $productCategory)
    {
        return ProductCategory::destroy($productCategory->id);
    }
}
