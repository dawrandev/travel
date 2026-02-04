<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HeroSlideController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\TourController;

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
        Route::post('/banner', [AboutController::class, 'storeBanner'])->name('banner.store');
        Route::put('/banner/{id}', [AboutController::class, 'updateBanner'])->name('banner.update');
        Route::get('/banner/{id}/translations', [AboutController::class, 'getBannerTranslations'])->name('banner.translations');
    });

    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [ContactController::class, 'index'])->name('index');
        Route::get('/filter', [ContactController::class, 'filter'])->name('filter');
        Route::get('/{id}/translations', [ContactController::class, 'getTranslations'])->name('translations');
        Route::post('/', [ContactController::class, 'store'])->name('store');
        Route::put('/{id}', [ContactController::class, 'update'])->name('update');
        Route::delete('/{id}', [ContactController::class, 'destroy'])->name('destroy');
        Route::post('/banner', [ContactController::class, 'storeBanner'])->name('banner.store');
        Route::put('/banner/{id}', [ContactController::class, 'updateBanner'])->name('banner.update');
        Route::get('/banner/{id}/translations', [ContactController::class, 'getBannerTranslations'])->name('banner.translations');
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
        Route::post('/banner', [ReviewController::class, 'storeBanner'])->name('banner.store');
        Route::put('/banner/{id}', [ReviewController::class, 'updateBanner'])->name('banner.update');
        Route::get('/banner/{id}/translations', [ReviewController::class, 'getBannerTranslations'])->name('banner.translations');
    });

    Route::prefix('features')->name('features.')->group(function () {
        Route::get('/', [FeatureController::class, 'index'])->name('index');
        Route::get('/filter', [FeatureController::class, 'filter'])->name('filter');
        Route::get('/{id}/translations', [FeatureController::class, 'getTranslations']);
        Route::post('/', [FeatureController::class, 'store'])->name('store');
        Route::put('/{id}', [FeatureController::class, 'update'])->name('update');
        Route::delete('/{id}', [FeatureController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('tours')->name('tours.')->group(function () {
        Route::get('/', [TourController::class, 'index'])->name('index');
        Route::get('/{id}', [TourController::class, 'show'])->name('show');
        Route::get('/{id}/translations', [TourController::class, 'getTranslations']);
        Route::post('/', [TourController::class, 'store'])->name('store');
        Route::put('/{id}', [TourController::class, 'update'])->name('update');
        Route::delete('/{id}', [TourController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('bookings')->name('bookings.')->group(function () {
        Route::get('/', [BookingController::class, 'index'])->name('index');
        Route::get('/{id}/show', [BookingController::class, 'show'])->name('show');
        Route::put('/{id}/status', [BookingController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{id}', [BookingController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('questions')->name('questions.')->group(function () {
        Route::get('/', [QuestionController::class, 'index'])->name('index');
        Route::get('/{id}/show', [QuestionController::class, 'show'])->name('show');
        Route::put('/{id}/status', [QuestionController::class, 'updateStatus'])->name('updateStatus');
        Route::delete('/{id}', [QuestionController::class, 'destroy'])->name('destroy');
    });
});
