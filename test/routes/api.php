<?php
use App\Http\Controllers\TestController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VerifyOtpController;
use App\Http\Controllers\OrderSummaryController;
use Illuminate\Support\Facades\Route;

Route::POST('/return', TestController::class);

// Waffarha API Mock Routes
Route::post('/transaction', [TransactionController::class, 'index']);
Route::post('/verify-otp', [VerifyOtpController::class, 'index']);
Route::post('/order-summary', [OrderSummaryController::class, 'index']);
