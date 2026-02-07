<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $lang = $request->header('Accept-Language', 'uz');
        $translation = $this->translations->firstWhere('lang_code', $lang)
                    ?? $this->translations->first();

        return [
            'id' => $this->id,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $translation->address ?? '',
            'longitude' => $this->longitude,
            'latitude' => $this->latitude,
            'telegram_url' => $this->telegram_url,
            'telegram_username' => $this->telegram_username,
            'instagram_url' => $this->instagram_url,
            'facebook_url' => $this->facebook_url,
            'facebook_name' => $this->facebook_name,
            'youtube_url' => $this->youtube_url,
            'whatsapp_phone' => $this->whatsapp_phone,
        ];
    }
}
