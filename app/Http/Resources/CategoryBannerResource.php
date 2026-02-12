<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryBannerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->header('Accept-Language', 'uz');
        $translation = $this->translations->firstWhere('lang_code', $lang)
            ?? $this->translations->first();

        $images = $this->images->sortBy('sort_order')->map(function($image) {
            return $this->formatImagePath($image->image_path);
        })->values()->toArray();

        return [
            'id' => $this->id,
            'title' => $translation->title ?? '',
            'images' => $images,
        ];
    }

    private function formatImagePath(?string $path): ?string
    {
        if (!$path) return null;

        if (preg_match('#https?://[^/]+(/storage/.+)#', $path, $matches)) {
            return $matches[1];
        }

        if (strpos($path, '/storage/') !== 0) {
            return '/storage/' . ltrim($path, '/');
        }

        return $path;
    }
}
