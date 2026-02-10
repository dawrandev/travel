<?php

use App\Http\Controllers\Api\AboutController;
use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\FaqController;
use App\Http\Controllers\Api\HeroSlideController;
use App\Http\Controllers\Api\LanguageController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\TourController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public API routes
Route::get('/languages', [LanguageController::class, 'index']);
Route::get('/faq', [FaqController::class, 'index']);
Route::get('/faq/categories', [FaqController::class, 'categories']);
Route::get('/about', [AboutController::class, 'index']);
Route::get('/about/banner', [AboutController::class, 'banner']);
Route::get('/contact', [ContactController::class, 'index']);
Route::get('/contact/banner', [ContactController::class, 'banner']);
Route::get('/hero-slides', [HeroSlideController::class, 'index']);

// Categories
Route::get('/categories', [CategoryController::class, 'index']);

// Tours
Route::get('/tours', [TourController::class, 'index']);
Route::get('/tours/top-rated', [TourController::class, 'topRated']);
Route::get('/tours/{id}', [TourController::class, 'show']);

// Reviews
Route::get('/reviews', [ReviewController::class, 'index']);
Route::get('/reviews/banner', [ReviewController::class, 'banner']);
Route::get('/reviews/{id}', [ReviewController::class, 'show']);

Route::post('/bookings', [BookingController::class, 'store'])->middleware('throttle:10,1');

Route::post('/questions', [QuestionController::class, 'store'])->middleware('throttle:10,1');
