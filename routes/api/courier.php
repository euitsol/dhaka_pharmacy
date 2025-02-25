<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Courier\WebHookController as CourierWebHookController;

Route::post('webhook', [CourierWebHookController::class, 'handler'])->middleware('webhook.auth');
