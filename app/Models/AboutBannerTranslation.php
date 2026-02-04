<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AboutBannerTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'about_banner_id',
        'lang_code',
        'title',
    ];

    public function aboutBanner(): BelongsTo
    {
        return $this->belongsTo(AboutBanner::class);
    }
}
