<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AwardTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'award_id',
        'lang_code',
        'description',
    ];

    public function award(): BelongsTo
    {
        return $this->belongsTo(Award::class);
    }
}
