<?php

use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ColorsController;
use App\Http\Controllers\MaterialsController;
use App\Http\Controllers\ProductsController;
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

Route::resource('product', ProductsController::class);
