<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourInclusionTranslation extends Model
{
    protected $fillable = [
        'tour_inclusion_id',
        'lang_code',
        'name',
        'description',
    ];

    public function inclusion()
    {
        return $this->belongsTo(TourInclusion::class);
    }
}
