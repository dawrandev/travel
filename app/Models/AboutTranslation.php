<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AboutTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'about_id',
        'title',
        'description',
        'lang_code',
    ];

    public function about(): BelongsTo
    {
        return $this->belongsTo(About::class);
    }
}
