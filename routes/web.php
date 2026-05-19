<?php

use App\Http\Controllers\FontController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/sitemap.xml', function () {
    $pages = [
        ['url' => '/', 'priority' => '1.0', 'changefreq' => 'weekly'],
        ['url' => '/examples', 'priority' => '0.8', 'changefreq' => 'monthly'],
        ['url' => '/privacy', 'priority' => '0.5', 'changefreq' => 'yearly'],
        ['url' => '/terms', 'priority' => '0.5', 'changefreq' => 'yearly'],
    ];

    return response()
        ->view('sitemap', [
            'pages' => $pages,
            'baseUrl' => rtrim(config('app.url'), '/'),
        ])
        ->header('Content-Type', 'application/xml');
})->name('sitemap');

Route::get('/robots.txt', function () {
    $content = implode("\n", [
        'User-agent: *',
        'Disallow: /dashboard',
        'Disallow: /history',
        'Disallow: /login',
        'Disallow: /register',
        'Disallow: /forgot-password',
        '',
        'Sitemap: ' . rtrim(config('app.url'), '/') . '/sitemap.xml',
    ]);

    return response($content)->header('Content-Type', 'text/plain');
})->name('robots');

Route::get('/', [FontController::class, 'index'])->name('home');
Route::post('/identify', [FontController::class, 'identify'])->name('identify');

Route::get('/results', function () {
    return Inertia::render('ResultsPage', [
        'fontResults' => session('fontResults'),
    ]);
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

Route::get('/history/{history}/image', [FontController::class, 'showHistoryImage'])
    ->middleware(['auth'])
    ->name('history.image');

require __DIR__.'/auth.php';
