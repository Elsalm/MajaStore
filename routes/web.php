<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ColorsController;
use App\Http\Controllers\IssueController;
use App\Http\Controllers\MaterialsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PanelController;
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
Route::post('/find/product', [ProductsController::class, 'getProductsByName']);

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

Route::get('/categories/{name}', [CategoriesController::class, 'getIdByName']);
Route::resource('product', ProductsController::class);
Route::resource('cart', CartController::class)->except(['create', 'edit']);
Route::delete('cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'destroy']);

    Route::get('/order', [OrderController::class, 'getUserOrders']);
    Route::post('/order', [OrderController::class, 'store']);
    Route::put('/order/{id}', [OrderController::class, 'update']);
    Route::post('/order/{id}/cancel', [OrderController::class, 'cancelOrder']);
    Route::get('/order/success', [OrderController::class, 'orderSuccess'])->name('order.success');
    Route::get('/order/canceled', [OrderController::class, 'getCanceledOrder']);
    Route::get('/order/all', [OrderController::class, 'getAllOrders']);
    Route::post('/issues', [IssueController::class, 'store']);
    Route::get('/issues', [IssueController::class, 'getAll']);
    Route::put('/issues/{id}/resolve', [IssueController::class, 'resolve']);
    Route::delete('/issues/{id}', [IssueController::class, 'destroy']);

    Route::get('/panel', [PanelController::class, 'index']);
});
