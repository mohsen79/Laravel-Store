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

Route::middleware('auth')->group(function () {
    Route::get('user/twofactauth', [Modules\Token\Http\Controllers\TokenController::class, 'show']);
    Route::post('user/twofactauth', [Modules\Token\Http\Controllers\TokenController::class, 'update'])->name('TwoFact.update');
    Route::get('user/token', [Modules\Token\Http\Controllers\TokenController::class, 'token']);
    Route::post('user/token{user}', [Modules\Token\Http\Controllers\TokenController::class, 'check'])->name('TwoFact.check');
});
Route::middleware('guest')->group(function () {
    Route::get('auth/login/token', [Modules\Token\Http\Controllers\LoginTwoFactController::class, 'logintoken']);
    Route::post('auth/login/token', [Modules\Token\Http\Controllers\LoginTwoFactController::class, 'logintokencheck'])->name('login.token');
});
