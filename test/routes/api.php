<?php
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::POST('/return', TestController::class);
