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
            'is_active' => $this->is_active,
            'title' => $translation->title ?? '',
            'subtitle' => $translation->subtitle ?? '',
            'description' => $translation->description ?? null,
        ];
    }

    /**
     * Rasmni /storage/uploads/filename.png formatiga keltiradi
     */
    private function formatImagePath(?string $path): ?string
    {
        if (!$path) {
            return null;
        }

        // 1. To'liq URL bo'lsa yo'lini ajratib olamiz
        if (preg_match('#https?://[^/]+(/storage/.+)#', $path, $matches)) {
            $path = $matches[1];
        }

        // 2. /storage/ bilan boshlanishini ta'minlaymiz
        if (strpos($path, '/storage/') !== 0) {
            if (strpos($path, 'storage/') === 0) {
                $path = '/' . $path;
            } else {
                $path = '/storage/' . $path;
            }
        }

        // 3. /uploads/ dan keyingi har qanday ichki papkani olib tashlaymiz
        // Masalan: /storage/uploads/heroslides/slide1.jpg -> /storage/uploads/slide1.jpg
        return preg_replace('#(/storage/uploads/)[^/]+/(.+)#', '$1$2', $path);
    }
}
