<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'email',
        'longitude',
        'latitude',
        'telegram_url',
        'telegram_username',
        'instagram_url',
        'facebook_url',
        'youtube_url',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(ContactTranslation::class);
    }
}
