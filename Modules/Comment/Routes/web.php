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

// use Modules\Comment\Http\Controllers\CommentController;

Route::prefix('admin')->group(function () {
    Route::resource('comments', CommentController::class);
    Route::get('approved', [Modules\Comment\Http\Controllers\CommentController::class, 'approved'])->name('comments.approved');
    Route::post('comment', [Modules\Comment\Http\Controllers\CommentController::class, 'comment'])->name('register.comment');
});
