<?php
use App\Http\Controllers\TestController;

use Illuminate\Support\Facades\Route;

Route::POST('/return', TestController::class);
Route::get('/sentry-test',
    fn() => throw new Exception('Sentry test',400));

Route::get('/sentry-test2',
    fn() => throw new \RuntimeException("Something went wrong", 100));

Route::get('/sentry-test3',
    fn() =>
   // throw new \InvalidArgumentException("not found2", 422));
    \Sentry\captureMessage('Payment gateway is slow'));

