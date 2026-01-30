<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewTranslation extends Model
{
    protected $fillable = [
        'review_id',
        'lang_code',
        'city',
        'comment',
    ];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}
