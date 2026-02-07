<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AboutBannerImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'about_banner_id',
        'image_path',
        'sort_order',
    ];

    public function banner(): BelongsTo
    {
        return $this->belongsTo(AboutBanner::class, 'about_banner_id');
    }
}
