<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ContactBannerTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'contact_banner_id',
        'lang_code',
        'title',
    ];

    public function contactBanner(): BelongsTo
    {
        return $this->belongsTo(ContactBanner::class);
    }
}
