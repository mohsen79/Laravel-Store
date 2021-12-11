<?php

use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Support\Facades\Route;
use Modules\Comment\Entities\Comment;
use phpDocumentor\Reflection\Location;

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

Route::get('/', [App\Http\Controllers\IndexController::class, 'show']);
Route::get('/information/{product}', function (Product $product) {
    if (!(isset($_SERVER['HTTP_CACHE_CONTROL']) && $_SERVER['HTTP_CACHE_CONTROL'] == 'max-age=0')) {
        $product->update(['view_count' => $product->view_count + 1]);
    }
    $comments = Comment::all();
    return view('information', compact('product', 'comments'));
});
Auth::routes(['verify' => true]);
Route::get('auth/google', [App\Http\Controllers\Auth\GoogleAuthController::class, 'redirect'])->name('google.auth');
Route::get('auth/google/callback', [App\Http\Controllers\Auth\GoogleAuthController::class, 'callback']);
Route::get('secret', function () {
    dd('dorud');
})->middleware(['auth', 'password.confirm']);
Route::get('user/profile', [\App\Http\Controllers\UserController::class, 'index']);
Route::get('user/{user}/edit', [\App\Http\Controllers\UserController::class, 'edit']);
Route::put('user/{user}/update', [\App\Http\Controllers\UserController::class, 'update'])->name('user.update');
Route::get('user/{user}/comments', [\App\Http\Controllers\UserController::class, 'comments'])->name('user.comments');
Route::get('user/{user}/comments/{comment}/edit', [\App\Http\Controllers\UserController::class, 'editcomment']);
Route::put('user/{comment}/comments/update', [\App\Http\Controllers\UserController::class, 'updatecomment']);
Route::delete('user/{user}/comments/{comment}/delete', [\App\Http\Controllers\UserController::class, 'delete']);
Route::match(['GET', 'POST'], 'product/filter', [App\Http\Controllers\IndexController::class, 'filter']);
Route::get('user/{user}/purchased', [\App\Http\Controllers\UserController::class, 'purchased']);
Route::get('user/{user}/Ajaxpurchased', [\App\Http\Controllers\UserController::class, 'AjaxPurchased']);