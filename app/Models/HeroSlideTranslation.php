<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HeroSlideTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_slide_id',
        'title',
        'subtitle',
        'lang_code',
    ];

    public function heroSlide(): BelongsTo
    {
        return $this->belongsTo(HeroSlide::class);
    }
}
