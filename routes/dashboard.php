<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\MySiteController;
use App\Http\Controllers\Dashboard\SiteMediaController;
use Inertia\Inertia;

Route::get('/', function () {
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

Route::get('/my-site', [MySiteController::class, 'index'])->name('dashboard.my-site');
Route::post('/my-site/update', [MySiteController::class, 'update'])->name('dashboard.my-site.update');
Route::post('/my-site/upload', [SiteMediaController::class, 'upload'])->name('dashboard.my-site.upload');
Route::get('/theme-store', [MySiteController::class, 'themeStore'])->name('dashboard.theme-store');

// CRUD POSTS.
Route::group(['prefix' => 'post'], function () {
    Route::get('/', [PostController::class, 'index'])->name('dashboard.post.index');
    Route::get('/create', [PostController::class, 'create'])->name('dashboard.post.create');
    Route::post('/store', [PostController::class, 'store'])->name('dashboard.post.store');
    Route::get('/{id}/edit', [PostController::class, 'edit'])->name('dashboard.post.edit');
    Route::post('/{id}/update', [PostController::class, 'update'])->name('dashboard.post.update');
    Route::post('/{id}/toggle-status', [PostController::class, 'toggleStatus'])->name('dashboard.post.toggle-status');
    Route::get('/{id}/delete', [PostController::class, 'destroy'])->name('dashboard.post.destroy');
});

// CRUD PRODUCTS.
Route::group(['prefix' => 'product'], function () {
    Route::get('/', [ProductController::class, 'index'])->name('dashboard.product.index');
    Route::get('/create', [ProductController::class, 'create'])->name('dashboard.product.create');
    Route::post('/store', [ProductController::class, 'store'])->name('dashboard.product.store');
    Route::get('/{id}/edit', [ProductController::class, 'edit'])->name('dashboard.product.edit');
    Route::post('/{id}/update', [ProductController::class, 'update'])->name('dashboard.product.update');
    Route::post('/{id}/toggle-publish', [ProductController::class, 'togglePublish'])->name('dashboard.product.toggle-publish');
    Route::get('/{id}/delete', [ProductController::class, 'destroy'])->name('dashboard.product.destroy');
});

// CRUD Categories.
Route::group(['prefix' => 'category'], function () {
    Route::get('/', [CategoryController::class, 'index'])->name('dashboard.category.index');
    Route::get('/create', [CategoryController::class, 'create'])->name('dashboard.category.create');
    Route::post('/store', [CategoryController::class, 'store'])->name('dashboard.category.store');
    Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('dashboard.category.edit');
    Route::post('/{id}/update', [CategoryController::class, 'update'])->name('dashboard.category.update');
    Route::get('/{id}/delete', [CategoryController::class, 'destroy'])->name('dashboard.category.destroy');
});
