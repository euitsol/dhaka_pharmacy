<?php

use App\Http\Controllers\Api\ApiInfoShareController;
use App\Http\Controllers\Api\Frontend\CategoryController;
use App\Http\Controllers\Api\Frontend\ProductController;
use App\Http\Controllers\Api\User\AddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\AuthenticationController;
use App\Http\Controllers\Api\User\CartAjaxController;
use App\Http\Controllers\Api\User\OrderController;
use App\Http\Controllers\Api\User\PaymentController;
use App\Http\Controllers\Api\User\SocialLoginController;
use App\Http\Controllers\Api\User\UserController;
use App\Http\Controllers\Api\User\WishlistController;
use App\Http\Controllers\Api\User\VoucherController;
use App\Http\Controllers\Api\User\PrescriptionController;

Route::group(['as' => 'u.', 'prefix' => 'user'], function () {

    Route::controller(AuthenticationController::class)->prefix('authentication')->name('auth.')->group(function () {
        Route::post('password-login', 'pass_login')->name('l.p');
        Route::post('send-otp', 'send_otp')->name('s.o');
        Route::post('verify-otp', 'otp_verify')->name('v.o');
        Route::post('registration', 'registration')->name('reg');
        Route::post('forgot-password/phone-check', 'fp_phone_check')->name('fp.pc');
        Route::post('forgot-password/verify-otp', 'fp_verify_otp')->name('fp.v.o');
        Route::post('forgot-password/update', 'fp_update')->name('fp.u');
    });
    Route::controller(SocialLoginController::class)->prefix('social-login')->name('social.')->group(function () {
        Route::post('/', 'social_login')->name('l');
    });

    Route::controller(UserController::class)->middleware('auth:api-user')->prefix('profile')->name('p')->group(function () {
        Route::get('/info', 'info')->name('info');
        Route::post('/update', 'update')->name('update');
        Route::post('/password/update', 'pass_update')->name('pass.update');
    });
    Route::controller(AddressController::class)->middleware('auth:api-user')->prefix('address')->name('address')->group(function () {
        Route::post('/store', 'store')->name('store');
        Route::post('/update', 'update')->name('update');
        Route::get('/list', 'list')->name('list');
        Route::get('/cities', 'cities')->name('cities');
        Route::post('/delete', 'delete')->name('delete');
    });
    // Cart API
    Route::controller(CartAjaxController::class)->middleware('auth:api-user')->prefix('cart')->name('cart.')->group(function () {
        Route::post('add', 'add')->name('add');
        Route::get('products', 'products')->name('products');
        Route::post('update', 'update')->name('update');
        Route::post('delete', 'delete')->name('delete');
    });
    Route::controller(OrderController::class)->middleware('auth:api-user')->prefix('order')->name('order.')->group(function () {
        Route::post('initiat', 'int_order')->name('i');
        Route::post('initiat/single', 'int_single_order')->name('s.i');
        Route::get('details', 'details')->name('d');
        Route::get('cancel', 'cancel')->name('cancel');
        Route::post('confirm', 'order_confirm')->name('c');
        Route::get('list', 'list')->name('l');
        Route::post('update-address', 'address')->name('update.address');
        Route::post('update-voucher', 'voucher')->name('update.voucher');
    });
    Route::controller(PaymentController::class)->middleware('auth:api-user')->prefix('payment')->name('payment.')->group(function () {
        Route::get('list', 'list')->name('l');
        Route::get('details', 'details')->name('d');
    });
    Route::controller(WishlistController::class)->middleware('auth:api-user')->prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('list', 'list')->name('l');
        Route::get('details', 'update')->name('d');
    });

    Route::controller(VoucherController::class)->middleware('auth:api-user')->prefix('voucher')->name('vouchers.')->group(function () {
        Route::post('check', 'check')->name('check');
    });

    Route::controller(PrescriptionController::class)->prefix('prescription')->name('prescription.')->group(function () {
        Route::post('upload', 'upload')->name('upload');
        Route::post('create', 'create')->name('create');
    });
});


Route::controller(ApiInfoShareController::class)->prefix('api-info')->name('api.')->group(function () {
    Route::get('/secure', 'secureApiInfo')->middleware('auth:api-user')->name('secure.i');
    Route::get('/social', 'socialApiInfo')->name('social.i');
});

Route::group(['as' => 'f.', 'prefix' => ''], function () {
    Route::controller(CategoryController::class)->prefix('categories')->name('cats.')->group(function () {
        Route::get('', 'categories')->name('list');
    });
    Route::controller(ProductController::class)->name('product.')->group(function () {
        Route::get('products', 'products')->name('multiple');
        Route::get('product', 'product')->name('details');
        Route::get('product/search', 'search')->name('search');
    });
});
