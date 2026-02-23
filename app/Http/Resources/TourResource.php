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
            'is_active' => $this->is_active,
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
        ];
    }

    private function formatImagePath(?string $path): ?string
    {
        if (!$path) return null;

        $filename = basename($path);

        return '/storage/uploads/' . $filename;
    }
}
