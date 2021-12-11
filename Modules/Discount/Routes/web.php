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

use Modules\Discount\Http\Controllers\CartDiscountController;

Route::resource('admin/discounts', DiscountController::class);
Route::post('admin/discount/check', [CartDiscountController::class, 'checkDiscount']);
Route::delete('admin/discount/delete', [CartDiscountController::class, 'delete']);
