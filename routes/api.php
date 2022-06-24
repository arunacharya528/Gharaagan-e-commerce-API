<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdvertisementController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\OrderDetailController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PageLinkController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductImageController;
use App\Http\Controllers\ProductInventoryController;
use App\Http\Controllers\ProductRatingController;
use App\Http\Controllers\QuestionAnswerController;
use App\Http\Controllers\ShoppingSessionController;
use App\Http\Controllers\SiteDetailController;
use App\Http\Controllers\UserAddressController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
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


//==================================
//
//  Routes that are open to all
//
//==================================

Route::get('/allProduct', [ProductController::class, 'getAll']);
Route::get('/oneProduct/{product}', [ProductController::class, 'show']);
Route::get('/allCategory', [ProductCategoryController::class, 'index']);
Route::get("/allBrand", [BrandController::class, 'index']);
Route::get('/activeAds', [AdvertisementController::class, 'activeAdvertisement']);
Route::get("/allSiteDetail", [SiteDetailController::class, 'index']);
Route::get("/allPageLinks", [PageLinkController::class, 'index']);
Route::get("/page/bySlug/{slug}", [PageController::class, 'showBySlug']);
Route::post('/newsletter/conditionalSubscribe', [EmailController::class, 'createConditionally']);
Route::get('/maintainance', function () {
    return response()->json(app()->isDownForMaintenance());
});

Route::post("/login", [AuthController::class, 'login']);
Route::get('unauthorized', function () {
    return response()->json([
        'error' => 'Unauthorized.'
    ], 401);
})->name('unauthorized');

//==================================
//
//  Routes that are protected collectively
//
//==================================

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::resource('product', ProductController::class);
    Route::resource('productCategory', ProductCategoryController::class);
    Route::resource('brand', BrandController::class);
    Route::resource('page', PageController::class);
    Route::resource('pageLink', PageLinkController::class);
    Route::resource("siteDetail", SiteDetailController::class);

    Route::get('user/session', [AuthController::class, 'getSession']);
    Route::get('user/orders', [AuthController::class, 'getOrderDetail']);
    Route::get('user/ratings', [AuthController::class, 'getRatings']);
    Route::get('user/questionAnswers', [AuthController::class, 'getQuestionAnswers']);
    Route::get('user/addresses', [AuthController::class, 'getAddresses']);
    Route::get('user/wishlist', [AuthController::class, 'getWishList']);
    Route::post('user/checkout', [AuthController::class, 'checkout']);

    Route::resource('advertisement', AdvertisementController::class);
    Route::get('discount/{discountName}/find', [DiscountController::class, 'findDiscount']);

    Route::resource('productInventory', ProductInventoryController::class);
    Route::resource('discount', DiscountController::class);
    Route::resource('user', UserController::class);
    Route::resource('userAddress', UserAddressController::class);
    Route::resource('shoppingSession', ShoppingSessionController::class);
    Route::resource('cartItem', CartItemController::class);

    Route::delete('orderDetail/{orderDetail}/cancel', [OrderDetailController::class, 'cancelOrder']);
    Route::resource('orderDetail', OrderDetailController::class);

    Route::resource('orderItem', OrderItemController::class);
    Route::resource('productRating', ProductRatingController::class);
    Route::resource('questionAnswer', QuestionAnswerController::class);
    Route::resource('productImage', ProductImageController::class);
    Route::resource('file', FileController::class);
    Route::resource('wishlist', WishlistController::class);
    Route::resource('newsletter', EmailController::class);

    Route::get('/logout', [AuthController::class, 'logout']);
});
