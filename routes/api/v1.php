<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\AuthenticationController;
use App\Http\Controllers\Api\User\UserController;

Route::group(['as' => 'u.', 'prefix' => 'user'], function () {

    Route::controller(AuthenticationController::class)->prefix('authentication')->name('auth.')->group(function () {
        Route::post('password-login', 'pass_login')->name('l.p');
        Route::post('otp-login', 'otp_login')->name('l.o');
    });


 Route::controller(UserController::class)->middleware('auth:api-user')->prefix('info')->name('info')->group(function () {
        Route::get('', 'info');
    });
});
