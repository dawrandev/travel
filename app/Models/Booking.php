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
        'phone_primary',
        'phone_secondary',
        'booking_date',
        'people_count',
        'comment',
        'total_price',
        'status',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'people_count' => 'integer',
        'total_price' => 'decimal:2',
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
