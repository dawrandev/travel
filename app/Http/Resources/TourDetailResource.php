<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourDetailResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->header('Accept-Language', 'uz');
        $translation = $this->translations->firstWhere('lang_code', $lang)
            ?? $this->translations->first();

        $categoryTranslation = $this->category->translations->firstWhere('lang_code', $lang)
            ?? $this->category->translations->first();

        $mainImage = $this->images->where('is_main', true)->first() ?? $this->images->first();

        return [
            'id' => $this->id,
            'slug' => $translation->slug ?? null,
            'title' => $translation->title ?? '',
            'slogan' => $translation->slogan ?? '',
            'description' => $translation->description ?? '',
            'routes' => $translation->routes ?? '',
            'important_info' => $translation->important_info ?? '',
            'price' => (float) $this->price,
            'phone' => $this->phone,
            'duration_days' => $this->duration_days,
            'duration_nights' => $this->duration_nights,
            'min_age' => $this->min_age,
            'max_people' => $this->max_people,
            'rating' => (float) $this->rating,
            'reviews_count' => $this->reviews_count,
            'category' => [
                'id' => $this->category->id,
                'name' => $categoryTranslation->name ?? '',
            ],

            'main_image' => $mainImage ? $this->formatImagePath($mainImage->image_path) : null,

            'images' => $this->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => $this->formatImagePath($image->image_path),
                    'is_main' => (bool) $image->is_main,
                ];
            }),

            'itineraries' => $this->itineraries->map(function ($itinerary) use ($lang) {
                $itTranslation = $itinerary->translations->firstWhere('lang_code', $lang)
                    ?? $itinerary->translations->first();

                return [
                    'day_number' => $itinerary->day_number,
                    'event_time' => $itinerary->event_time,
                    'activity_title' => $itTranslation->activity_title ?? '',
                    'activity_description' => $itTranslation->activity_description ?? '',
                ];
            }),

            'features' => $this->features->map(function ($feature) use ($lang) {
                $featureTranslation = $feature->translations->firstWhere('lang_code', $lang)
                    ?? $feature->translations->first();

                return [
                    'id' => $feature->id,
                    'name' => $featureTranslation->name ?? '',
                    'description' => $featureTranslation->description ?? '',
                    'icon' => $feature->icon,
                    'is_included' => (bool) $feature->pivot->is_included,
                ];
            }),

            'faq' => $this->faqs
                ->where('is_active', true)
                ->sortBy('sort_order')
                ->groupBy('faq_category_id')
                ->map(function ($faqs, $categoryId) use ($lang) {
                    $firstFaq = $faqs->first();
                    $categoryTranslation = $firstFaq->category
                        ? ($firstFaq->category->translations->firstWhere('lang_code', $lang)
                            ?? $firstFaq->category->translations->first())
                        : null;

                    return [
                        'title' => $categoryTranslation->name ?? '',
                        'questions' => $faqs->map(function ($faq) use ($lang) {
                            $translation = $faq->translations->firstWhere('lang_code', $lang)
                                ?? $faq->translations->first();

                            return [
                                'question' => $translation->question ?? '',
                                'answer' => $translation->answer ?? '',
                            ];
                        })->values(),
                    ];
                })
                ->values(),

            'gif_map' => $this->gif_map ? '/storage/' . $this->gif_map : null,

            'accommodations' => $this->accommodations->map(function ($accommodation) use ($lang) {
                $accTranslation = $accommodation->translations->firstWhere('lang_code', $lang)
                    ?? $accommodation->translations->first();

                return [
                    'day_number'  => $accommodation->day_number,
                    'type'        => $accommodation->type,
                    'name'        => $accTranslation->name ?? '',
                    'description' => $accTranslation->description ?? '',
                    'price'       => $accommodation->price !== null ? (float) $accommodation->price : null,
                    'image'       => $accommodation->image_path
                        ? '/storage/uploads/' . basename($accommodation->image_path)
                        : null,
                ];
            })->values(),
        ];
    }

    private function formatImagePath(?string $path): ?string
    {
        if (!$path) return null;

        $filename = basename($path);

        return '/storage/uploads/' . $filename;
    }
}
