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
        $reviews = $this->reviewService->getAll();
        $banner = ReviewBanner::first();
        $languages = Language::all();
        $tours = Tour::with('translations')->get();
        return view('pages.reviews.index', compact('reviews', 'banner', 'languages', 'tours'));
    }

    public function filter(Request $request): JsonResponse
    {
        $langCode = $request->get('lang_code', 'en');
        $reviews = $this->reviewService->getAllByLanguage($langCode);

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
                'rating' => $review->rating,
                'video_url' => $review->video_url,
                'sort_order' => $review->sort_order,
                'is_active' => $review->is_active
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
        $this->reviewService->delete($id);
        return redirect()->route('reviews.index')->with('success', 'Отзыв успешно удален');
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

        return response()->json([
            'success' => true,
            'banner' => [
                'id' => $banner->id,
                'image' => $banner->image,
                'is_active' => $banner->is_active
            ],
            'translations' => $translations
        ]);
    }
}
