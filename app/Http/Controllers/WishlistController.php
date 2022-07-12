<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $wishlist = Wishlist::with(['product', 'user'])->get();
        // return response()->json($wishlist);
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
        if (Auth::user()->role !== 3) {
            return redirect()->route('unauthorized');
        }
        $request['user_id'] = Auth::user()->id;
        $wish = Wishlist::create($request->all());
        return response()->json($wish);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function show(Wishlist $wishlist)
    {
        // $wish = Wishlist::with(['product', 'user'])->find($wishlist->id);
        // return response()->json($wish);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Wishlist  $wishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(Wishlist $wishlist)
    {
        if (Auth::user()->role !== 3) {
            return redirect()->route('unauthorized');
        }

        if (Auth::user()->id !== $wishlist->user_id) {
            return redirect()->route('unauthorized');
        }
        return Wishlist::destroy($wishlist->id);
    }

    // public function wishListExists(Request $request)
    // {
    //     $query = [];
    //     $product_id = $request->input('product_id');
    //     if ($product_id !== null) {
    //         $query['product_id'] = $product_id;
    //     } else {
    //         return response()->json('Missing product id', 400);
    //     }
    //     $user_id = $request->input('user_id');
    //     if ($user_id !== null) {
    //         $query['user_id'] = $user_id;
    //     } else {
    //         return response()->json('Missing user id', 400);
    //     }

    //     $wishlist = Wishlist::where($query);
    //     if ($wishlist->exists()) {
    //         return response()->json($wishlist->first());
    //     } else {
    //         return response()->json('Does not exist', 204);
    //     }
    // }
}
