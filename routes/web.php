<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ColorsController;
use App\Http\Controllers\MaterialsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home.index');
});

Route::get('/featured/products', [ProductsController::class, 'featuredProducts']);
Route::get('/products/all', [ProductsController::class, 'getProducts']);
Route::post('/products/all', [ProductsController::class, 'getProducts']);
Route::get('/colors', [ColorsController::class, 'index']);
Route::get('/materials', [MaterialsController::class, 'index']);
Route::get('/categories', [CategoriesController::class, 'index']);

/* auth(por ahora)🥸 */

Route::controller(AuthController::class)->group(function () {
    Route::get('login', 'index');
    Route::post('login', 'store');
    Route::get('me', 'me');
});

Route::controller(UserController::class)->group(function () {
    Route::get('register', 'create');
    Route::post('user', 'store');

});

Route::resource('product', ProductsController::class)->except(['create']);
Route::resource('cart', CartController::class)->except(['create', 'edit']);
Route::delete('cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/products/create', [ProductsController::class, 'create']);
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'destroy']);
    Route::resource('/order', OrderController::class)->only(['store']);
    Route::get('/order/success', [OrderController::class, 'orderSuccess'])->name('order.success');
});
