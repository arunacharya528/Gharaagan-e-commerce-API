<?php

namespace App\Http\Controllers;

use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserAddressController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $userAddresses = UserAddress::get();
        // return response()->json($userAddresses);
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

        $userAddress = UserAddress::create($request->all());
        return response()->json($userAddress);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function show(UserAddress $userAddress)
    {
        // $userAddress = UserAddress::find($userAddress->id);
        // return response()->json($userAddress);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function edit(UserAddress $userAddress)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserAddress $userAddress)
    {
        if (Auth::user()->role !== 3) {
            return redirect()->route('unauthorized');
        }
        if (Auth::user()->role === 3 && $userAddress->user_id !== Auth::user()->id) {
            return redirect()->route('unauthorized');
        }

        $userAddress = UserAddress::find($userAddress->id);
        $userAddress->update($request->all());
        return response()->json($userAddress);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserAddress  $userAddress
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserAddress $userAddress)
    {
        if (Auth::user()->role !== 3) {
            return redirect()->route('unauthorized');
        }
        if (Auth::user()->role === 3 && $userAddress->user_id !== Auth::user()->id) {
            return redirect()->route('unauthorized');
        }

        return UserAddress::destroy($userAddress->id);
    }
}
