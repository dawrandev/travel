<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'tour_id',
        'user_name',
        'email',
        'phone_primary',
        'phone_secondary',
        'comment',
        'status',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function getStatusLabelAttribute()
    {
        return [
            'pending'  => 'Kutilmoqda',
            'answered' => 'Javob berildi',
        ][$this->status] ?? $this->status;
    }
}
