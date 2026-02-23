<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReviewResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->header('Accept-Language', 'uz');
        $translation = $this->translations->firstWhere('lang_code', $lang)
                    ?? $this->translations->first();

        return [
            'id' => $this->id,
            'user_name' => $this->user_name,
            'city' => $translation?->city ?? '',
            'comment' => $translation?->comment ?? '',
            'rating' => $this->rating,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
            'video_url' => $this->video_url,
            'review_url' => $this->review_url,
            'tour' => $this->when($this->tour, function () use ($lang) {
                $tourTranslation = $this->tour->translations->firstWhere('lang_code', $lang)
                            ?? $this->tour->translations->first();

                return [
                    'id' => $this->tour->id,
                    'title' => $tourTranslation?->title ?? '',
                ];
            }),
        ];
    }
}
