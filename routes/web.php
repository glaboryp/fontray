<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FontController;
use Inertia\Inertia;

Route::get('/', [FontController::class, 'index'])->name('home');
Route::post('/identify', [FontController::class, 'identify'])->name('identify');

// Results page
Route::get('/results', function () {
    return Inertia::render('ResultsPage');
})->name('results');

// Examples page
Route::get('/examples', function () {
    return Inertia::render('ExamplesPage');
})->name('examples');

// Static pages
Route::get('/privacy', function () {
    return Inertia::render('PrivacyPage');
})->name('privacy');

Route::get('/terms', function () {
    return Inertia::render('TermsPage');
})->name('terms');
