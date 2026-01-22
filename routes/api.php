<?php

use App\API\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::apiResource('orders', OrderController::class);
