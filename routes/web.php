<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FontController;

Route::get('/', [FontController::class, 'index'])->name('home');
Route::post('/identify', [FontController::class, 'identify'])->name('identify');
