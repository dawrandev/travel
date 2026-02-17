<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'price',
        'phone',
        'rating',
        'reviews_count',
        'duration_days',
        'duration_nights',
        'min_age',
        'max_people',
        'is_active',
        'gif_map',
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

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function faqs()
    {
        return $this->hasMany(Faq::class);
    }

    public function accommodations()
    {
        return $this->hasMany(TourAccommodation::class)->orderBy('day_number');
    }

}
