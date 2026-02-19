<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'tour_id',
        'user_name',
        'email',
        'rating',
        'video_url',
        'review_url',
        'is_active',
        'is_checked',
        'client_created',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_checked' => 'boolean',
        'client_created' => 'boolean',
        'rating' => 'integer',
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
