<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\GetAttributeValue;
use App\Http\Controllers\Admin\PermissionsController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductGalleryController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\User\PermissionController;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Modules\Action\Entities\Action;
use Modules\Cart\Entities\Cart;

Auth::routes(['verify' => true]);
Route::resource('users', UserController::class);
Route::resource('permissions', PermissionsController::class);
Route::resource('roles', RoleController::class);
Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
// Route::resource('product.gallery', ProductGalleryController::class);
// Route::resource('comments', CommentController::class);


Route::get('user/{user}/permissions', [PermissionController::class, 'index']);
Route::post('user/{user}/permissions', [PermissionController::class, 'update'])->name('user.permission.update');
Route::get('subcategory/{category}', [SubCategoryController::class, 'create']);
Route::post('subcategory/{category}/store', [SubCategoryController::class, 'store'])->name('subcategory.store');
Route::get('subcategory/{category}/edit', [SubCategoryController::class, 'edit']);
Route::post('subcategory/{category}/update', [SubCategoryController::class, 'update'])->name('subcategory.update');
Route::delete('subcategory/{category}/destroy', [SubCategoryController::class, 'destroy'])->name('subcategory.destroy');
Route::post('attribute/value', [GetAttributeValue::class, 'getvalue']);
Route::get('purchased', function () {
    $carts = Cart::all();
    return view('admin.purchased', compact('carts'));
})->name('purchased');
Route::patch('purchased/status', function (Request $request) {
    $cart = collect(json_decode($request->cart));
    $cart = Cart::find($cart["id"]);
    return $cart->update(
        ['status' => $request->status]
    );
})->name('update.status');
Route::delete('delete/{cart}', function (Cart $cart) {
    $cart->delete();
    return back();
})->name('purchased.delete');
