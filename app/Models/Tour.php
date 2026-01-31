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
        'duration',
        'min_age',
        'max_people'
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
}
