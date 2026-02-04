<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewBannerTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_banner_id',
        'lang_code',
        'title',
    ];

    public function reviewBanner(): BelongsTo
    {
        return $this->belongsTo(ReviewBanner::class);
    }
}
