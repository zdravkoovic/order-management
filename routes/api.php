<?php

use App\API\Controllers\OrderController;
use App\API\Controllers\OrderlineController;
use Illuminate\Support\Facades\Route;

Route::apiResource('orders', OrderController::class);
Route::apiResource('orderlines', OrderlineController::class);