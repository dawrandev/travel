<?php

namespace App\Services;

use App\Models\Language;
use App\Repositories\ReviewRepository;

class ReviewService
{
    public function __construct(
        protected ReviewRepository $reviewRepository
    ) {}

    public function getAll()
    {
        return $this->reviewRepository->getAll();
    }

    public function getAllByLanguage(string $langCode, ?string $search = null)
    {
        $reviews = $this->reviewRepository->getAll();

        $mappedReviews = $reviews->map(function ($review) use ($langCode) {
            $translation = $review->translations->where('lang_code', $langCode)->first();
            return [
                'id' => $review->id,
                'user_name' => $review->user_name,
                'city' => $translation->city ?? 'N/A',
                'comment' => $translation->comment ?? 'N/A',
                'rating' => $review->rating,
                'video_url' => $review->video_url,
                'review_url' => $review->review_url,
                'tour_name' => $review->tour->translations->where('lang_code', $langCode)->first()->title ?? 'N/A',
                'sort_order' => $review->sort_order,
                'is_active' => $review->is_active
            ];
        });

        // Apply search filter if provided
        if (!empty($search)) {
            $search = mb_strtolower($search);
            $mappedReviews = $mappedReviews->filter(function ($review) use ($search) {
                return str_contains(mb_strtolower($review['user_name']), $search) ||
                       str_contains(mb_strtolower($review['city']), $search) ||
                       str_contains(mb_strtolower($review['comment']), $search) ||
                       str_contains(mb_strtolower($review['tour_name']), $search);
            })->values();
        }

        return $mappedReviews;
    }

    public function findById(int $id)
    {
        return $this->reviewRepository->findById($id);
    }

    public function create(array $data)
    {
        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['rating'] = $data['rating'] ?? 5;

        $review = $this->reviewRepository->create($data);

        // Create translations for all languages
        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->reviewRepository->createTranslation($review->id, [
                'city' => $data['city_' . $langCode] ?? '',
                'comment' => $data['comment_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $review;
    }

    public function update(int $id, array $data)
    {
        $review = $this->reviewRepository->findById($id);

        $data['is_active'] = isset($data['is_active']) ? 1 : 0;
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['rating'] = $data['rating'] ?? 5;

        $this->reviewRepository->update($review, $data);

        // Delete old translations and create new ones
        $review->translations()->delete();

        $languages = Language::all();
        foreach ($languages as $language) {
            $langCode = $language->code;
            $this->reviewRepository->createTranslation($review->id, [
                'city' => $data['city_' . $langCode] ?? '',
                'comment' => $data['comment_' . $langCode] ?? '',
                'lang_code' => $langCode,
            ]);
        }

        return $review;
    }

    public function delete(int $id)
    {
        $review = $this->reviewRepository->findById($id);
        return $this->reviewRepository->delete($review);
    }
}
