<?php
use App\Http\Controllers\TestController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VerifyOtpController;
use App\Http\Controllers\OrderSummaryController;
use Illuminate\Support\Facades\Route;

Route::GET('/return', TestController::class);

