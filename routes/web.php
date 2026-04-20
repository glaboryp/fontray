<?php

use App\Http\Controllers\FontController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [FontController::class, 'index'])->name('home');
Route::post('/identify', [FontController::class, 'identify'])->name('identify');

Route::get('/results', function () {
    return Inertia::render('ResultsPage');
})->name('results');

Route::get('/examples', function () {
    return Inertia::render('ExamplesPage');
})->name('examples');

Route::get('/privacy', function () {
    return Inertia::render('PrivacyPage');
})->name('privacy');

Route::get('/terms', function () {
    return Inertia::render('TermsPage');
})->name('terms');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/history', [FontController::class, 'history'])
    ->middleware(['auth'])
    ->name('history');

require __DIR__.'/auth.php';
