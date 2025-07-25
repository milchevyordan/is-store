<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/product/{slug}', [HomeController::class, 'product'])->name('product');
Route::post('/cart/add', [CartController::class, 'addProduct'])->name('cart.add');


Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->name('admin.')->prefix('/admin')->group(function () {
    Route::resource('category', CategoryController::class)->names('categories')->except(['show']);
    Route::resource('product', ProductController::class)->names('products')->except(['show']);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
