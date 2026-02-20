<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

# PROD
// require_once __DIR__ . '/domain.php';

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');



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

# DEV
require_once __DIR__ . '/domain.php';
