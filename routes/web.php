<?php

use App\Models\OrderDetail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get("/view/bill/{orderDetail}", function (OrderDetail $orderDetail) {
    $orderDetail = OrderDetail::with([
        'address.delivery',
        'user',
        'discount',
        'orderItems.inventory',
        'orderItems.product'
    ])->find($orderDetail->id);
    // $orderDetail =
    // dd($orderDetail);
    return view('invoice', ['orderDetail' => $orderDetail]);
});
