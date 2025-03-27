<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MarkerController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/markers', [MarkerController::class, 'index'])->name('markers.index');
Route::post('/markers', [MarkerController::class, 'store'])->name('markers.store');
Route::get('/markers/all', [MarkerController::class, 'show'])->name('markers.show');
Route::put('/markers/{marker}', [MarkerController::class, 'update'])->name('markers.update');
Route::post('/markers/{marker}', [MarkerController::class, 'update']);
Route::delete('/markers/{marker}', [MarkerController::class, 'destroy'])->name('markers.destroy');