<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('cart/{product}/AddToCart', [Modules\Cart\Http\Controllers\CartController::class, 'AddToCart'])->name('add.to.cart');
Route::get('cart', [Modules\Cart\Http\Controllers\CartController::class, 'index'])->name('cart.index');
Route::patch('/cart/quantity/update', [Modules\Cart\Http\Controllers\CartController::class, 'QuantityChange']);
Route::delete('cart/remove/{product}', [Modules\Cart\Http\Controllers\CartController::class, 'remove']);
Route::post('cart/pay/{total_price}', [Modules\Cart\Http\Controllers\CartController::class, 'StoreCart']);
Route::get('cart/pay/callback', [Modules\Cart\Http\Controllers\CartController::class, 'callback'])->name('callback');
Route::get('order', [Modules\Cart\Http\Controllers\CartController::class, 'order']);
