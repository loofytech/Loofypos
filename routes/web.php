<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Helpers\MyHelper;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'auth', 'controller' => AuthController::class], function() {
    Route::get("", function() {
        return redirect()->route('login');
    });
    Route::get('signin', 'signin')->name('login');
    Route::post('signin', 'signinPost')->name('login.post');
});

Route::group(['prefix' => 'store', 'middleware' => ['auth']], function() {
    Route::get('', function() {
        if (MyHelper::getActiveStore()) {
            return redirect()->route('dashboard', MyHelper::getActiveStore());
        }
        return "no active store";
    });
    Route::group(['prefix' => '{store_slug?}'], function() {
        Route::get('', [PageController::class, 'dashboard'])->name('dashboard');
        Route::get('product', [PageController::class, 'product'])->name('product');
        Route::post('product', [ProductController::class, 'store'])->name('product.post');
    });
});
