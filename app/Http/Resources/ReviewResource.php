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
            'rating' => $this->rating,
            'review_text' => $translation->review_text ?? '',
            'video_url' => $this->video_url,
            'tour' => $this->when($this->tour, function () use ($lang) {
                $tourTranslation = $this->tour->translations->firstWhere('lang_code', $lang)
                            ?? $this->tour->translations->first();

                return [
                    'id' => $this->tour->id,
                    'title' => $tourTranslation->title ?? '',
                ];
            }),
        ];
    }
}
