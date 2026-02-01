<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourInclusion extends Model
{
    protected $fillable = [
        'tour_id',
        'feature_id',
        'is_included'
    ];

    protected $casts = [
        'is_included' => 'boolean',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}
