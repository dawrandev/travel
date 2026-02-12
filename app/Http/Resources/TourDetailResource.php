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

            'faqs' => $this->faqs
                ->where('is_active', true)
                ->sortBy('sort_order')
                ->values()
                ->map(function ($faq) use ($lang) {
                    $translation = $faq->translations->firstWhere('lang_code', $lang)
                        ?? $faq->translations->first();

                    return [
                        'id' => $faq->id,
                        'question' => $translation->question ?? '',
                        'answer' => $translation->answer ?? '',
                        'sort_order' => $faq->sort_order,
                        'faq_category_id' => $faq->faq_category_id,
                    ];
                }),

            'route' => $this->waypoints->map(fn($w) => [
                'sort_order' => $w->sort_order,
                'latitude'   => (float) $w->latitude,
                'longitude'  => (float) $w->longitude,
            ])->values()->toArray(),
        ];
    }

    private function formatImagePath(?string $path): ?string
    {
        if (!$path) return null;

        $filename = basename($path);

        return '/storage/uploads/' . $filename;
    }
}
