<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HeroSlideController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReviewController;

Route::get('/', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::middleware('admin')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::prefix('hero-slides')->name('hero-slides.')->group(function () {
        Route::get('/', [HeroSlideController::class, 'index'])->name('index');
        Route::get('/filter', [HeroSlideController::class, 'filter'])->name('filter');
        Route::get('/{id}/translations', [HeroSlideController::class, 'getTranslations'])->name('translations');
        Route::post('/', [HeroSlideController::class, 'store'])->name('store');
        Route::put('/{id}', [HeroSlideController::class, 'update'])->name('update');
        Route::delete('/{id}', [HeroSlideController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('faqs')->name('faqs.')->group(function () {
        Route::get('/', [FaqController::class, 'index'])->name('index');
        Route::get('/filter', [FaqController::class, 'filter'])->name('filter');
        Route::get('/{id}/translations', [FaqController::class, 'getTranslations'])->name('translations');
        Route::post('/', [FaqController::class, 'store'])->name('store');
        Route::put('/{id}', [FaqController::class, 'update'])->name('update');
        Route::delete('/{id}', [FaqController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('abouts')->name('abouts.')->group(function () {
        Route::get('/', [AboutController::class, 'index'])->name('index');
        Route::get('/filter', [AboutController::class, 'filter'])->name('filter');
        Route::get('/{id}/translations', [AboutController::class, 'getTranslations'])->name('translations');
        Route::post('/', [AboutController::class, 'store'])->name('store');
        Route::put('/{id}', [AboutController::class, 'update'])->name('update');
        Route::delete('/{id}', [AboutController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('index');
        Route::get('/filter', [ContactController::class, 'filter'])->name('filter');
        Route::get('/{id}/translations', [ContactController::class, 'getTranslations'])->name('translations');
        Route::post('/', [ContactController::class, 'store'])->name('store');
        Route::put('/{id}', [ContactController::class, 'update'])->name('update');
        Route::delete('/{id}', [ContactController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('categories')->name('categories.')->group(function () {
        Route::get('/', [CategoryController::class, 'index'])->name('index');
        Route::get('/filter', [CategoryController::class, 'filter'])->name('filter');
        Route::get('/{id}/translations', [CategoryController::class, 'getTranslations']);
        Route::post('/', [CategoryController::class, 'store'])->name('store');
        Route::put('/{id}', [CategoryController::class, 'update'])->name('update');
        Route::delete('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [ReviewController::class, 'index'])->name('index');
        Route::get('/filter', [ReviewController::class, 'filter'])->name('filter');
        Route::get('/{id}/translations', [ReviewController::class, 'getTranslations']);
        Route::post('/', [ReviewController::class, 'store'])->name('store');
        Route::put('/{id}', [ReviewController::class, 'update'])->name('update');
        Route::delete('/{id}', [ReviewController::class, 'destroy'])->name('destroy');
    });
});
