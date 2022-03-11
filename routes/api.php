<?php

use App\Http\Controllers\DiscountController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductInventoryController;
use App\Http\Controllers\ShoppingSessionController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserController;
use App\Models\UserAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::resource('product', ProductController::class);
Route::resource('productCategory', ProductCategoryController::class);
Route::resource('productInventory', ProductInventoryController::class);
Route::resource('discount', DiscountController::class);
Route::resource('user', UserController::class);
Route::resource('userAddress', UserAddressController::class);
Route::resource('shoppingSession', ShoppingSessionController::class);
