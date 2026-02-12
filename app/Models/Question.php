<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    protected $fillable = [
        'tour_id',
        'full_name',
        'email',
        'phone',
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
