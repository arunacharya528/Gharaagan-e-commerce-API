<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductInventoryController;
use App\Http\Controllers\ProductRatingController;
use App\Http\Controllers\QuestionAnswerController;
use App\Http\Controllers\ShoppingSessionController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserController;
use App\Models\ProductRating;
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


Route::group(['prefix' => 'auth', 'namespace' => 'Api'], function () {

    Route::post('register',     [AuthController::class, 'register']);

    /* ------------------------ For Personal Access Token ----------------------- */
    Route::post('login',        [AuthController::class, 'login']);
    /* -------------------------------------------------------------------------- */

    /* ------------------------ For Password Grant Token ------------------------ */
    Route::post('login_grant',  [AuthController::class, 'loginGrant']);
    Route::post('refresh',      [AuthController::class, 'refreshToken']);
    /* -------------------------------------------------------------------------- */

    Route::get('logout',    [AuthController::class, 'logout'])->middleware('auth:api');

    /* -------------------------------- Fallback -------------------------------- */
    Route::any('{segment}', function () {
        return response()->json([
            'error' => 'Invalid url.'
        ]);
    })->where('segment', '.*');
});

Route::get('unauthorized', function () {
    return response()->json([
        'error' => 'Unauthorized.'
    ], 401);
})->name('unauthorized');

/*-------------------Added middleware in controller-------------------*/
Route::get('product/all', [ProductController::class, 'getAll']);
Route::resource('product', ProductController::class);

Route::resource('advertisement', AdvertisementController::class);
Route::get('activeAdvertisement', [AdvertisementController::class, 'activeAdvertisement']);
Route::resource('productCategory', ProductCategoryController::class);
Route::resource('brand', BrandController::class);

/*-------------------Explicit middleware in all-------------------*/
// Route::group(['middleware' => 'auth:api'], function () {
Route::resource('productInventory', ProductInventoryController::class);
Route::resource('discount', DiscountController::class);
Route::resource('user', UserController::class);
Route::resource('userAddress', UserAddressController::class);
Route::resource('shoppingSession', ShoppingSessionController::class);
Route::post('shoppingSession/{session_id}/createOrder', [ShoppingSessionController::class, 'createOrder']);
Route::resource('cartItem', CartItemController::class);
Route::delete('cartItem/deleteBySession/{session_id}', [CartItemController::class, 'deleteBySession']);
Route::get('cartItem/session/{session_id}/product/{product_id}', [CartItemController::class, 'getBySessionAndProduct']);
Route::resource('orderDetail', OrderDetailController::class);
Route::get('orderDetail/byUser/{user_id}', [OrderDetailController::class, 'getByUser']);
Route::delete('orderDetail/{order_id}/cancel', [OrderDetailController::class, 'cancelOrder']);
Route::resource('orderItem', OrderItemController::class);

Route::resource('productRating', ProductRatingController::class);
Route::resource('questionAnswer', QuestionAnswerController::class);
// });

Route::resource('file', FileController::class);
