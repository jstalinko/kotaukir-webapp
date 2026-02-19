<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

require_once __DIR__ . '/domain.php';
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::get('dashboard', function () {
    $user = auth()->user();
    return Inertia::render('Dashboard', [
        'stats' => [
            'totalProducts' => $user->products()->count(),
            'totalCategories' => $user->categories()->count(),
            'totalViews' => $user->products()->sum('views'),
            'accountLevel' => $user->level ?? 'basic',
        ],
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('explore', function () {
    return Inertia::render('Explore');
})->name('explore');

Route::get('about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('contact', function () {
    return Inertia::render('Contact');
})->name('contact');

require __DIR__ . '/settings.php';
Route::group(['prefix' => 'dashboard'], function () {
    require __DIR__ . '/dashboard.php';
});
