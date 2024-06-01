<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\AuthenticationController;

Route::group(['as' => 'u.', 'prefix' => 'user'], function () {

    Route::controller(AuthenticationController::class)->prefix('authentication')->name('u.auth.')->group(function () {
        Route::post('password-login', 'pass_login')->name('l.p');
        Route::post('otp-login', 'otp_login')->name('l.o');
    });

});
