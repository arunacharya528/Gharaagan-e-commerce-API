<?php

use App\Http\Controllers\MailController;
use App\Http\Controllers\OrderDetailController;
use App\Models\OrderDetail;
use Illuminate\Mail\Markdown;
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

// Route::get("/view/bill/{orderDetail}", function (OrderDetail $orderDetail) {
//     $orderDetail = OrderDetail::with([
//         'address.delivery',
//         'user',
//         'discount',
//         'orderItems.inventory',
//         'orderItems.product'
//     ])->find($orderDetail->id);
//     // $orderDetail =
//     // dd($orderDetail);
//     return view('invoice', ['orderDetail' => $orderDetail]);
// });


// Route::get("/view/mailTemplate", function () {
//     //     return view("vendor.mail.html.message", ['subcopy' => "
//     // <h1>This if title of the body</h1>
//     // <p>This is a paragraph of the body</p>
//     // "])->render();

//     $markdown = new Markdown(view(), config('mail.markdown'));
//     return $markdown->render('vendor.mail.html.message', ['slot' => "
//      <h1>This is title of the body</h1>
//      <p>This is a paragraph of the body</p>
//      "]);
// });

// Route::post("/sendmail", [MailController::class, 'sendMail']);

Route::get("/view/invoice/{orderDetail}", [OrderDetailController::class, 'streamInvoice'])->middleware(["auth:sanctum"]);
