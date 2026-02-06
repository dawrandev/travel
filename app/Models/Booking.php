<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'tour_id',
        'full_name',
        'max_people',
        'starting_date',
        'ending_date',
        'primary_phone',
        'secondary_phone',
        'email',
        'message',
        'status',
    ];

    protected $casts = [
        'starting_date' => 'date',
        'ending_date' => 'date',
        'max_people' => 'integer',
    ];

    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    public function getStatusLabelAttribute()
    {
        return [
            'pending'   => 'Kutilmoqda',
            'confirmed' => 'Tasdiqlandi',
            'cancelled' => 'Bekor qilindi',
        ][$this->status] ?? $this->status;
    }
}
