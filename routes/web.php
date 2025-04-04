<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MarkerController;
use App\Http\Controllers\WeatherController;
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

Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/posts', [AdminPostController::class, 'index'])->name('posts.index');
    Route::get('/posts/{post}/edit', [AdminPostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [AdminPostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [AdminPostController::class, 'destroy'])->name('posts.destroy');
    
    Route::get('/users', [AdminPostController::class, 'users'])->name('users');
    Route::get('/comments', [AdminPostController::class, 'comments'])->name('comments');
    Route::delete('/comments/{comment}', [AdminPostController::class, 'destroyComment'])->name('comments.destroy');
});

Route::resource('posts', PostController::class)->only(['index', 'show']);

Route::get('/map', [MarkerController::class, 'index'])->name('map');
Route::get('/markers', [MarkerController::class, 'show'])->name('markers.show');
Route::post('/markers', [MarkerController::class, 'store'])->name('markers.store');
Route::put('/markers/{marker}', [MarkerController::class, 'update'])->name('markers.update');
Route::delete('/markers/{marker}', [MarkerController::class, 'destroy'])->name('markers.destroy');

Route::get('/weather/{city}', [WeatherController::class, 'getWeather'])->name('weather');

require __DIR__.'/auth.php';