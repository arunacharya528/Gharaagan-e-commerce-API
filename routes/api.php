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

Route::get('/allProduct', [ProductController::class, 'getAll']); //done
Route::get('/oneProduct/{product}', [ProductController::class, 'show']); //done
Route::get('/allCategory', [ProductCategoryController::class, 'index']); //done
Route::get("/allBrand", [BrandController::class, 'index']); //done
Route::get("/oneBrand/{brand}", [BrandController::class, 'show']); //done
Route::get('/activeAds', [AdvertisementController::class, 'activeAdvertisement']); //done
Route::get("/allSiteDetail", [SiteDetailController::class, 'index']); //done
Route::get("/allPageLinks", [PageLinkController::class, 'index']); //done
Route::get("/page/bySlug/{slug}", [PageController::class, 'showBySlug']); //done
Route::post('/newsletter/conditionalSubscribe', [EmailController::class, 'createConditionally']); //done
Route::get('/maintainance', function () {
    return response()->json(app()->isDownForMaintenance());
});
Route::post("/register", [AuthController::class, 'registerClient']); //done
Route::post("/login", [AuthController::class, 'login'])->name('login'); //done
Route::post("/get-if-logged-in", [AuthController::class, 'getIfLoggedIn']);
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
    Route::resource('product', ProductController::class); //done
    Route::resource('productCategory', ProductCategoryController::class); //done
    Route::resource('brand', BrandController::class); //done
    Route::resource('page', PageController::class); //done
    Route::resource('pageLink', PageLinkController::class); //done
    Route::resource("siteDetail", SiteDetailController::class); //done

    Route::get('user/session', [AuthController::class, 'getSession']); //done
    Route::get('user/orders', [AuthController::class, 'getOrderDetail']); //done
    Route::get('user/ratings', [AuthController::class, 'getRatings']); //done
    Route::get('user/questionAnswers', [AuthController::class, 'getQuestionAnswers']); //done
    Route::get('user/addresses', [AuthController::class, 'getAddresses']); //done
    Route::get('user/wishlist', [AuthController::class, 'getWishList']); //done
    Route::post('user/checkout', [AuthController::class, 'checkout']); //done

    Route::resource('advertisement', AdvertisementController::class); //done
    Route::get('discount/{discountName}/find', [DiscountController::class, 'findDiscount']); //done

    Route::resource('productInventory', ProductInventoryController::class); //done
    Route::resource('discount', DiscountController::class); //done
    Route::resource('user', UserController::class); //done
    Route::resource('userAddress', UserAddressController::class); //disintegrate and allow for auth user only
    Route::resource('shoppingSession', ShoppingSessionController::class); //done
    Route::resource('cartItem', CartItemController::class);//donw

    Route::delete('orderDetail/{orderDetail}/cancel', [OrderDetailController::class, 'cancelOrder']);//donw
    Route::get("/orderDetail/{orderDetail}/invoice", [OrderDetailController::class, 'streamInvoice']);//donw
    Route::resource('orderDetail', OrderDetailController::class);//donw

    // Route::resource('orderItem', OrderItemController::class);
    Route::resource('productRating', ProductRatingController::class); //done

    Route::resource('questionAnswer', QuestionAnswerController::class);
    Route::resource('productImage', ProductImageController::class); //done
    Route::resource('file', FileController::class); //done
    Route::resource('wishlist', WishlistController::class);//done
    Route::resource('newsletter', EmailController::class); //done
    Route::resource('delivery', DeliveryController::class);//done

    Route::get('logout', [AuthController::class, 'logout']);
});
