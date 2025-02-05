<?php

use App\Http\Controllers\PayController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('deposit', [PayController::class, 'deposit']);
Route::post('webhooks/get-response', [PayController::class, 'responseSupeWallet']);
