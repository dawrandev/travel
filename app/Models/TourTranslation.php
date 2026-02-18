<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourTranslation extends Model
{
    protected $fillable = [
        'tour_id',
        'lang_code',
        'title',
        'slogan',
        'description',
        'routes',
        'important_info',
        'slug',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
}
