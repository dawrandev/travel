<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReviewBannerImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_banner_id',
        'image_path',
        'sort_order',
    ];

    public function banner(): BelongsTo
    {
        return $this->belongsTo(ReviewBanner::class, 'review_banner_id');
    }
}
