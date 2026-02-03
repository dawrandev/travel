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

        return [
            'id' => $this->id,
            'image' => $this->formatImagePath($this->image),
            'title' => $translation->title ?? '',
            'description' => $translation->description ?? '',
            'images' => $this->images->map(function ($image) {
                return [
                    'id' => $image->id,
                    'image_path' => $this->formatImagePath($image->image_path),
                    'sort_order' => $image->sort_order,
                ];
            }),
        ];
    }

    /**
     * Format image path - remove domain if exists, ensure it starts with /storage/
     */
    private function formatImagePath(?string $path): ?string
    {
        if (!$path) return null;

        if (preg_match('#https?://[^/]+(/storage/.+)#', $path, $matches)) {
            $path = $matches[1];
        }

        if (strpos($path, '/storage/') !== 0) {
            $path = (strpos($path, 'storage/') === 0) ? '/' . $path : '/storage/' . $path;
        }

        $cleanPath = preg_replace('#(/storage/uploads/)[^/]+/(.+)#', '$1$2', $path);

        return $cleanPath;
    }
}
