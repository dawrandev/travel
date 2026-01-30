<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'tour_id',
        'user_name',
        'rating',
        'video_url',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function translations()
    {
        return $this->hasMany(ReviewTranslation::class);
    }
}
