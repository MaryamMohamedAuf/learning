<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Counter;

Route::get('/counter', Counter::class);
Route::get('/', function () {
    return view('welcome');
});
//Route::get('/return', TestController::class);
Route::get('/sentry-test3', function () {
    \Sentry\captureMessage('Payment gateway is slow');
    return "Sent test message to Sentry";
});
