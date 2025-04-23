<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MarkerController;
use App\Http\Controllers\WeatherController;
use App\Http\Controllers\GameViewController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('posts', PostController::class)->except(['index', 'show']);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
Route::get('/shop/{product}', [ShopController::class, 'show'])->name('shop.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::put('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/remove-item/{id}', [CartController::class, 'removeItem'])->name('cart.removeItem');

Route::get('/checkout', [CartController::class, 'checkout'])->name('checkout');
Route::post('/order', [CartController::class, 'processOrder'])->name('order.process');
Route::get('/order/confirmation', [CartController::class, 'confirmation'])->name('order.confirmation');
Route::get('/payment', [CartController::class, 'payment'])->name('payment');
Route::post('/payment/process', [CartController::class, 'processPayment'])->name('payment.process');
Route::post('/payment/process-stripe', [CartController::class, 'processStripePayment'])->name('payment.process-stripe');

Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/posts', [AdminPostController::class, 'index'])->name('posts.index');
    Route::get('/posts/{post}/edit', [AdminPostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [AdminPostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [AdminPostController::class, 'destroy'])->name('posts.destroy');
    
    Route::get('/users', [AdminPostController::class, 'users'])->name('users');
    Route::get('/comments', [AdminPostController::class, 'comments'])->name('comments');
    Route::delete('/comments/{comment}', [AdminPostController::class, 'destroyComment'])->name('comments.destroy');
});

Route::get('/games', [App\Http\Controllers\GameViewController::class, 'index'])->name('games.index');
Route::get('/games/create', [App\Http\Controllers\GameViewController::class, 'create'])->middleware(['auth'])->name('games.create');
Route::post('/games', [App\Http\Controllers\GameViewController::class, 'store'])->middleware(['auth'])->name('games.store');
Route::get('/games/{id}', [App\Http\Controllers\GameViewController::class, 'show'])->name('games.show');
Route::get('/games/{id}/edit', [App\Http\Controllers\GameViewController::class, 'edit'])->middleware(['auth'])->name('games.edit');
Route::put('/games/{id}', [App\Http\Controllers\GameViewController::class, 'update'])->middleware(['auth'])->name('games.update');
Route::delete('/games/{id}', [App\Http\Controllers\GameViewController::class, 'destroy'])->middleware(['auth'])->name('games.destroy');

Route::resource('posts', PostController::class)->only(['index', 'show']);

Route::get('/map', [MarkerController::class, 'index'])->name('map');
Route::get('/markers', [MarkerController::class, 'show'])->name('markers.show');
Route::post('/markers', [MarkerController::class, 'store'])->name('markers.store');
Route::put('/markers/{marker}', [MarkerController::class, 'update'])->name('markers.update');
Route::delete('/markers/{marker}', [MarkerController::class, 'destroy'])->name('markers.destroy');

Route::get('/weather/{city}', [WeatherController::class, 'getWeather'])->name('weather');

require __DIR__.'/auth.php';