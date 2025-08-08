<?php
use App\Http\Controllers\TestController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VerifyOtpController;
use App\Http\Controllers\OrderSummaryController;
use Illuminate\Support\Facades\Route;

Route::POST('/return', TestController::class);

// Waffarha API Mock Routes
Route::get('/transaction', [TransactionController::class, 'index']);
Route::get('/verify-otp', [VerifyOtpController::class, 'index']);
Route::get('/order-summary', [OrderSummaryController::class, 'index']);
