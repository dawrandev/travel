<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = [
        'category_id',
        'price',
        'rating',
        'reviews_count',
        'duration_days',
        'duration_nights',
        'min_age',
        'max_people',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'price' => 'decimal:2',
        'rating' => 'decimal:1',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function translations()
    {
        return $this->hasMany(TourTranslation::class);
    }

    public function inclusions()
    {
        return $this->hasMany(TourInclusion::class);
    }

    public function itineraries()
    {
        return $this->hasMany(TourItinerary::class);
    }

    public function images()
    {
        return $this->hasMany(TourImage::class);
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'tour_inclusions')
            ->withPivot('is_included')
            ->withTimestamps();
    }
}
