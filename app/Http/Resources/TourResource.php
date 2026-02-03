<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TourResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->header('Accept-Language', 'uz');
        $translation = $this->translations->firstWhere('lang_code', $lang)
            ?? $this->translations->first();

        $categoryTranslation = $this->category->translations->firstWhere('lang_code', $lang)
            ?? $this->category->translations->first();

        // Asosiy rasm
        $mainImage = $this->images->where('is_main', true)->first() ?? $this->images->first();

        return [
            'id' => $this->id,
            'title' => $translation->title ?? '',
            'slogan' => $translation->slogan ?? '',
            'description' => $translation->description ?? '',
            'routes' => $translation->routes ?? '',
            'important_info' => $translation->important_info ?? '',
            'price' => (float) $this->price,
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

            // MANA SHU YERDA /storage/uploads/rasm.jpg bo'lib chiqadi
            'main_image' => $mainImage ? $this->formatImagePath($mainImage->image_path) : null,

            'images' => $this->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'url' => $this->formatImagePath($image->image_path), // Bu yerda ham /storage/uploads/
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
                ];
            }),
        ];
    }

    /**
     * Barcha ichki papkalarni (tours, about, h.k.) qirqib tashlaydi
     * Faqat /storage/uploads/filename.png qoldiradi
     */
    private function formatImagePath(?string $path): ?string
    {
        if (!$path) return null;

        // 1. To'liq URL (http...) bo'lsa yo'lini ajratamiz
        if (preg_match('#https?://[^/]+(/storage/.+)#', $path, $matches)) {
            $path = $matches[1];
        }

        // 2. /storage/ bilan boshlanishini ta'minlaymiz
        if (strpos($path, '/storage/') !== 0) {
            $path = (strpos($path, 'storage/') === 0) ? '/' . $path : '/storage/' . $path;
        }

        return preg_replace('#(/storage/uploads/)[^/]+/(.+)#', '$1$2', $path);
    }
}
