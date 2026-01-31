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
            'image_path' => $this->image_path,
            'sort_order' => $this->sort_order,
            'title' => $translation->title ?? '',
            'subtitle' => $translation->subtitle ?? '',
        ];
    }
}
