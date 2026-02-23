<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AboutResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->header('Accept-Language', 'uz');
        $translation = $this->translations->firstWhere('lang_code', $lang)
            ?? $this->translations->first();

        $award = null;
        if ($this->award) {
            $awardTranslation = $this->award->translations->firstWhere('lang_code', $lang)
                ?? $this->award->translations->first();

            $award = [
                'description' => $awardTranslation->description ?? '',
                'images' => $this->award->images->map(function ($image) {
                    return [
                        'id' => $image->id,
                        'image_path' => $this->formatImagePath($image->image_path),
                    ];
                }),
            ];
        }

        return [
            'id' => $this->id,
            'title' => $translation->title ?? '',
            'description' => $translation->description ?? '',
            'is_active' => $this->is_active,
            'images' => $this->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'image_path' => $this->formatImagePath($image->image_path),
                ];
            }),
            'award' => $award,
        ];
    }

    /**
     * Format image path - ensure it starts with /storage/
     */
    private function formatImagePath(?string $path): ?string
    {
        if (!$path) return null;

        // Remove domain if exists
        if (preg_match('#https?://[^/]+(/storage/.+)#', $path, $matches)) {
            return $matches[1];
        }

        // Ensure path starts with /storage/
        if (strpos($path, '/storage/') !== 0) {
            return '/storage/' . ltrim($path, '/');
        }

        return $path;
    }
}
