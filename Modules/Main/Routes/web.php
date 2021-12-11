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
Route::resource('admin/main', MainController::class);
Route::post('admin/main/enable/{module}', [Modules\Main\Http\Controllers\MainController::class, 'enable'])->name('module.enable');
Route::post('admin/main/disable/{module}', [Modules\Main\Http\Controllers\MainController::class, 'disable'])->name('module.disable');
