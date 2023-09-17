<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;
use App\Helpers\MyHelper;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoreController;
use Illuminate\Support\Facades\Request;

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

Route::group(['prefix' => 'store/{store_slug}', 'middleware' => ['auth', 'activeStore']], function() {
    Route::get('', [PageController::class, 'dashboard'])->name('dashboard');

    Route::group(['prefix' => 'product'], function() {
        Route::get('', [PageController::class, 'product'])->name('product');
        Route::post('', [ProductController::class, 'store'])->name('product.post');
    });
    Route::group(['prefix' => 'product'], function() {
        Route::get('data', [ProductController::class, 'index'])->name('product.data');
    });
    Route::group(['prefix' => 'store'], function() {
        Route::post('change', [StoreController::class, 'changeStoreActive'])->name('store.change');
    });
});
