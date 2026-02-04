<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewBannerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->header('Accept-Language', 'uz');
        $translation = $this->translations->firstWhere('lang_code', $lang)
            ?? $this->translations->first();

        return [
            'id' => $this->id,
            'title' => $translation->title ?? '',
            'image' => $this->formatImagePath($this->image),
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
