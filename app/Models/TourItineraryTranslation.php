<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourItineraryTranslation extends Model
{
    protected $fillable = [
        'tour_itenerary_id',
        'lang_code',
        'activity_title',
        'activity_description',
    ];

    public function tourItenerary()
    {
        return $this->belongsTo(TourItinerary::class);
    }
}
