<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ProductController;

// Основные маршруты
Route::get('/', [HomeController::class, 'index'])->name('home');
 Route::get('/catalog', [ProductController::class, 'index'])->name('catalog');

 // Корзина
Route::prefix('cart')->name('cart.')->group(function() {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
    
});


 
// Оформление заказа
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/orders', [CheckoutController::class, 'store'])->name('orders.store');

// Маршруты корзины
/* Route::prefix('cart')->name('cart.')->group(function() {
    Route::get('/', [CartController::class, 'index'])->name('index'); // cart.index
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
}); */

// Маршруты оформления заказа
Route::prefix('checkout')->group(function() {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/', [CheckoutController::class, 'store'])->name('checkout.store');
});

// Админка для управления товарами
Route::middleware(['auth'])->prefix('admin')->group(function() {
    Route::resource('products', ProductController::class);
});

// Страница товара
Route::get('/catalog/{product}', [ProductController::class, 'show'])->name('catalog.show');