<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewBannerRequest;
use App\Http\Requests\StoreReviewRequest;
use App\Models\Language;
use App\Models\ReviewBanner;
use App\Models\Tour;
use App\Services\ReviewBannerService;
use App\Services\ReviewService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    public function __construct(
        protected ReviewService $reviewService,
        protected ReviewBannerService $reviewBannerService
    ) {}

    public function index(): View
    {
        $reviews = \App\Models\Review::with('translations', 'tour.translations')
            ->where('client_created', false)
            ->orderBy('created_at', 'desc')
            ->get();
        $banner = ReviewBanner::first();
        $languages = Language::where('is_active', true)->get();
        $tours = Tour::with('translations')->get();
        $pendingCount = \App\Models\Review::where('client_created', true)->where('is_checked', false)->count();
        return view('pages.reviews.index', compact('reviews', 'banner', 'languages', 'tours', 'pendingCount'));
    }

    public function adminReviews(): View
    {
        $reviews = \App\Models\Review::with('translations', 'tour.translations')
            ->where('client_created', false)
            ->orderBy('created_at', 'desc')
            ->get();
        $banner = ReviewBanner::first();
        $languages = Language::where('is_active', true)->get();
        $tours = Tour::with('translations')->get();
        return view('pages.reviews.admin-reviews', compact('reviews', 'banner', 'languages', 'tours'));
    }

    public function clientReviews(): View
    {
        $reviews = \App\Models\Review::with('translations', 'tour.translations')
            ->where('client_created', true)
            ->orderBy('is_checked', 'asc')
            ->orderBy('created_at', 'desc')
            ->get();
        $languages = Language::where('is_active', true)->get();
        $tours = Tour::with('translations')->get();
        $pendingCount = \App\Models\Review::where('client_created', true)->where('is_checked', false)->count();
        return view('pages.reviews.client-reviews', compact('reviews', 'languages', 'tours', 'pendingCount'));
    }

    public function filter(Request $request): JsonResponse
    {
        $langCode = $request->get('lang_code', 'ru');
        $search = $request->get('search');
        $adminOnly = $request->get('adminOnly', false);
        $isChecked = $request->get('is_checked');
        $reviews = $this->reviewService->getAllByLanguage($langCode, $search, $adminOnly, $isChecked);

        return response()->json([
            'success' => true,
            'data' => $reviews
        ]);
    }

    public function getTranslations(int $id): JsonResponse
    {
        $review = $this->reviewService->findById($id);
        $translations = [];

        foreach ($review->translations as $translation) {
            $translations[$translation->lang_code] = [
                'city' => $translation->city,
                'comment' => $translation->comment
            ];
        }

        return response()->json([
            'success' => true,
            'review' => [
                'id' => $review->id,
                'tour_id' => $review->tour_id,
                'user_name' => $review->user_name,
                'email' => $review->email,
                'rating' => $review->rating,
                'video_url' => $review->video_url,
                'review_url' => $review->review_url,
                'sort_order' => $review->sort_order,
                'is_active' => $review->is_active,
                'is_checked' => $review->is_checked
            ],
            'translations' => $translations
        ]);
    }

    public function store(StoreReviewRequest $request): RedirectResponse
    {
        $this->reviewService->create($request->validated());
        return redirect()->route('reviews.index')->with('success', 'Отзыв успешно создан');
    }

    public function update(StoreReviewRequest $request, int $id): RedirectResponse
    {
        $this->reviewService->update($id, $request->validated());
        return redirect()->route('reviews.index')->with('success', 'Отзыв успешно обновлен');
    }

    public function destroy(int $id): RedirectResponse
    {
        $review = \App\Models\Review::findOrFail($id);
        $isClientReview = $review->client_created;

        $this->reviewService->delete($id);

        $route = $isClientReview ? 'reviews.client' : 'reviews.index';
        return redirect()->route($route)->with('success', 'Отзыв успешно удален');
    }

    public function approve(int $id): RedirectResponse
    {
        $review = \App\Models\Review::findOrFail($id);
        $review->update(['is_checked' => true]);
        return redirect()->back()->with('success', 'Отзыв успешно одобрен');
    }

    public function storeBanner(ReviewBannerRequest $request): RedirectResponse
    {
        $this->reviewBannerService->create($request->validated());
        return redirect()->route('reviews.index')->with('success', 'Баннер успешно создан');
    }

    public function updateBanner(ReviewBannerRequest $request, int $id): RedirectResponse
    {
        $this->reviewBannerService->update($id, $request->validated());
        return redirect()->route('reviews.index')->with('success', 'Баннер успешно обновлен');
    }

    public function getBannerTranslations(int $id): JsonResponse
    {
        $banner = $this->reviewBannerService->findById($id);

        $translations = [];
        foreach ($banner->translations as $translation) {
            $translations[$translation->lang_code] = [
                'title' => $translation->title,
            ];
        }

        $images = $banner->images->sortBy('sort_order')->map(function ($image) {
            return [
                'id' => $image->id,
                'image_path' => $image->image_path,
                'sort_order' => $image->sort_order,
            ];
        })->values()->toArray();

        return response()->json([
            'success' => true,
            'banner' => [
                'id' => $banner->id,
                'is_active' => $banner->is_active
            ],
            'translations' => $translations,
            'images' => $images
        ]);
    }
}
