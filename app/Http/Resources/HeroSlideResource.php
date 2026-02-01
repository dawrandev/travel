<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HeroSlideResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->header('Accept-Language', 'uz');
        $translation = $this->translations->firstWhere('lang_code', $lang)
                    ?? $this->translations->first();

        return [
            'id' => $this->id,
            'image_path' => $this->formatImagePath($this->image_path),
            'sort_order' => $this->sort_order,
            'title' => $translation->title ?? '',
            'subtitle' => $translation->subtitle ?? '',
            'description' => $translation->description ?? null,
        ];
    }

    /**
     * Format image path - remove domain if exists, ensure it starts with /storage/
     */
    private function formatImagePath(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        // If it's already a full URL, extract the path part
        if (preg_match('#https?://[^/]+(/storage/.+)#', $path, $matches)) {
            return $matches[1];
        }

        // If it already starts with /storage/, return as is
        if (strpos($path, '/storage/') === 0) {
            return $path;
        }

        // If it starts with storage/ (without leading slash), add leading slash
        if (strpos($path, 'storage/') === 0) {
            return '/' . $path;
        }

        // Otherwise, prepend /storage/
        return '/storage/' . $path;
    }
}
