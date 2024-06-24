<?php

use App\Http\Controllers\Api\Frontend\CategoryController;
use App\Http\Controllers\Api\User\AddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\AuthenticationController;
use App\Http\Controllers\Api\User\UserController;

Route::group(['as' => 'u.', 'prefix' => 'user'], function () {

    Route::controller(AuthenticationController::class)->prefix('authentication')->name('auth.')->group(function () {
        Route::post('password-login', 'pass_login')->name('l.p');
        Route::post('send-otp', 'send_otp')->name('s.o');
        Route::post('verify-otp', 'otp_verify')->name('v.o');

        Route::post('registration', 'registration')->name('reg');
    });

    Route::controller(UserController::class)->middleware('auth:api-user')->prefix('info')->name('info')->group(function () {
        Route::get('', 'info');
    });
    Route::controller(AddressController::class)->middleware('auth:api-user')->prefix('address')->name('address')->group(function () {
        Route::post('/store', 'store')->name('store');
        Route::post('/update', 'update')->name('update');
    });
});

Route::group(['as' => 'f.', 'prefix' => 'frontend'], function () {
    Route::controller(CategoryController::class)->prefix('categories')->name('cats.')->group(function () {
        Route::get('/{is_featured?}', 'categories')->name('list');
    });
});
