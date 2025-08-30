<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FontController;
use Inertia\Inertia;

Route::get('/', [FontController::class, 'index'])->name('home');
Route::post('/identify', [FontController::class, 'identify'])->name('identify');

// Static pages
Route::get('/privacy', function () {
    return Inertia::render('PrivacyPage');
})->name('privacy');

Route::get('/terms', function () {
    return Inertia::render('TermsPage');
})->name('terms');
