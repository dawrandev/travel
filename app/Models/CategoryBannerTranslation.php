<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CategoryBannerTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_banner_id',
        'lang_code',
        'title',
    ];

    public function categoryBanner(): BelongsTo
    {
        return $this->belongsTo(CategoryBanner::class);
    }
}
