<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategoryBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function translations(): HasMany
    {
        return $this->hasMany(CategoryBannerTranslation::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(CategoryBannerImage::class);
    }
}
