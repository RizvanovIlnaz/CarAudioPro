<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\{
    HomeController,
    CartController,
    CheckoutController,
    ProductController,
    ProfileController,
    OrderController
};
use App\Http\Controllers\Admin\{
    DashboardController,
    CategoryController,
    ProductController as AdminProductController,
    OrderController as AdminOrderController
};
use App\Http\Controllers\Auth\{
    LoginController,
    RegisterController,
    ForgotPasswordController,
    ResetPasswordController
};

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Основные маршруты (публичные)
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/catalog', [ProductController::class, 'index'])->name('catalog');
Route::get('/catalog/{product}', [ProductController::class, 'show'])->name('catalog.show');

Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

// Корзина
Route::prefix('cart')->name('cart.')->group(function() {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('add');
    Route::patch('/update/{id}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{id}', [CartController::class, 'remove'])->name('remove');
});

// Оформление заказа
Route::middleware(['auth'])->group(function() {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/orders', [CheckoutController::class, 'store'])->name('orders.store');
    
    
    // История заказов
    Route::get('/orders/history', [OrderController::class, 'history'])->name('orders.history');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
// Аутентификация
Route::middleware('guest')->group(function() {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
    // Маршруты сброса пароля
    Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])
         ->name('password.request');
         
    Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])
         ->name('password.email');
         
    Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])
         ->name('password.reset');
         
    Route::post('/reset-password', [ResetPasswordController::class, 'reset'])
         ->name('password.update');
});
// Маршрут для страницы верификации email (например, для отображения уведомления)
Route::middleware(['auth'])->get('/email/verify', function () {
    return view('auth.verify');
})->name('verification.notice');

// Маршрут для повторной отправки кода верификации email
Route::middleware(['auth'])->post('/email/resend', 'App\Http\Controllers\Auth\VerificationController@resend')->name('verification.send');

// Группа для аутентифицированных пользователей
Route::middleware(['auth'])->group(function () {
    // Профиль пользователя
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});
Route::put('/password', [ProfileController::class, 'updatePassword'])->name('password.update');

Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Админ-панель

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function() {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    


    // Ресурсы админки
    Route::resource('categories', CategoryController::class)->except('show');
    Route::resource('products', AdminProductController::class);
    
    
    // Управление заказами
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.updateStatus');
});