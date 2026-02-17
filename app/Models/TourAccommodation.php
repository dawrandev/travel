<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourAccommodation extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'day_number',
        'type',
        'price',
        'image_path',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function translations()
    {
        return $this->hasMany(TourAccommodationTranslation::class);
    }
}
