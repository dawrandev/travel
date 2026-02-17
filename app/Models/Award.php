<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Award extends Model
{
    use HasFactory;

    protected $fillable = [
        'about_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function about(): BelongsTo
    {
        return $this->belongsTo(About::class);
    }

    public function translations(): HasMany
    {
        return $this->hasMany(AwardTranslation::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(AwardImage::class);
    }
}
