<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->header('Accept-Language', 'uz');
        $translation = $this->translations->firstWhere('lang_code', $lang)
                    ?? $this->translations->first();

        return [
            'id' => $this->id,
            'sort_order' => $this->sort_order,
            'question' => $translation->question ?? '',
            'answer' => $translation->answer ?? '',
        ];
    }
}
