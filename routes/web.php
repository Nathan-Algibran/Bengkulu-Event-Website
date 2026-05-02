<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin;
use App\Http\Controllers\User as UserController;

// Landing Page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Auth Routes (Breeze)
require __DIR__.'/auth.php';

// ===========================
// ADMIN ROUTES
// ===========================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'active', 'role:admin'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [Admin\DashboardController::class, 'index'])
            ->name('dashboard');

        // Manajemen Kategori
        Route::resource('categories', Admin\CategoryController::class);

        // Manajemen Event
        Route::resource('events', Admin\EventController::class);

        // Manajemen Pengguna
        Route::get('users', [Admin\UserController::class, 'index'])->name('users.index');
        Route::get('users/{user}', [Admin\UserController::class, 'show'])->name('users.show');
        Route::patch('users/{user}/toggle-active', [Admin\UserController::class, 'toggleActive'])
            ->name('users.toggleActive');

        // Manajemen Rekomendasi
        Route::get('recommendations', [Admin\RecommendationController::class, 'index'])
            ->name('recommendations.index');
        Route::patch('recommendations/{event}/toggle-recommended', [Admin\RecommendationController::class, 'toggleRecommended'])
            ->name('recommendations.toggleRecommended');
        Route::patch('recommendations/{event}/toggle-popular', [Admin\RecommendationController::class, 'togglePopular'])
            ->name('recommendations.togglePopular');
        Route::get('recommendations/statistics', [Admin\RecommendationController::class, 'statistics'])
            ->name('recommendations.statistics');
    });

// ===========================
// USER ROUTES
// ===========================
Route::prefix('user')
    ->name('user.')
    ->middleware(['auth', 'active', 'role:user'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [UserController\DashboardController::class, 'index'])
            ->name('dashboard');

        // Akun Pengguna
        Route::get('profile', [UserController\ProfileController::class, 'edit'])
            ->name('profile.edit');
        Route::patch('profile', [UserController\ProfileController::class, 'update'])
            ->name('profile.update');
        Route::delete('profile', [UserController\ProfileController::class, 'destroy'])
            ->name('profile.destroy');

        // Eksplorasi Event
        Route::get('events', [UserController\EventController::class, 'index'])
            ->name('events.index');
        Route::get('events/{slug}', [UserController\EventController::class, 'show'])
            ->name('events.show');

        // Interaksi Event (Favorit)
        Route::post('favorites/{event}', [UserController\FavoriteController::class, 'store'])
            ->name('favorites.store');
        Route::delete('favorites/{event}', [UserController\FavoriteController::class, 'destroy'])
            ->name('favorites.destroy');
        Route::get('favorites', [UserController\FavoriteController::class, 'index'])
            ->name('favorites.index');

        // Sistem Rekomendasi
        Route::get('recommendations', [UserController\RecommendationController::class, 'index'])
            ->name('recommendations.index');
    });