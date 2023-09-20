<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellingController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('products', [ProductController::class, 'getProductTest']);
Route::post('checkout', [SellingController::class, 'checkout']);