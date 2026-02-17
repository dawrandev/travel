<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TourAccommodationTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_accommodation_id',
        'lang_code',
        'name',
        'description',
    ];

    public function accommodation()
    {
        return $this->belongsTo(TourAccommodation::class, 'tour_accommodation_id');
    }
}
