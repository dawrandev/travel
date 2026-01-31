<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourInclusion extends Model
{
    protected $fillable = [
        'tour_id',
        'is_included',
        'icon',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function translations()
    {
        return $this->hasMany(TourInclusionTranslation::class);
    }
}
