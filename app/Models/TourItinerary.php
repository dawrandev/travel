<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourItinerary extends Model
{
    protected $fillable = [
        'tour_id',
        'day_number',
        'event_time',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
