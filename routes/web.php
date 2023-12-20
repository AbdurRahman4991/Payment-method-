<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SslCommerzPaymentController;
use App\Http\Controllers\StripeController;
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider and all of them will
 * | be assigned to the "web" middleware group. Make something great!
 * |
 */

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/post/page', [App\Http\Controllers\NotificationController::class, 'postPage'])->name('postPage');
Route::post('/new/lession', [App\Http\Controllers\NotificationController::class, 'newLession'])->name('newLession');
Route::get('/mark/all/read', [App\Http\Controllers\NotificationController::class, 'markRead'])->name('readNotification');

// PRODUCT PAGE//

Route::get('/product', [HomeController::class, 'product'])->name('product');
Route::get('/product/details/{id}', [HomeController::class, 'productDetails'])->name('productDetails');
Route::post('/webhook', [HomeController::class, 'webHook'])->name('webHook');

// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
// SSLCOMMERZ END

// Paypal //

Route::get('/paypal', [App\Http\Controllers\HomeController::class, 'payPal'])->name('payPal');

// Paypal End //

// Stripe payment//

Route::get('/stripe', [App\Http\Controllers\StripeController::class, 'stripeCheckOut'])->name('stripeCheckOut');

Route::get('/success', [StripeController::class, 'successStripe'])->name('successStripe');

Route::get('/pyment/history', [StripeController::class, 'PaymentHistroy'])->name('paymentHistory');
