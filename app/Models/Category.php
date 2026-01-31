<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function tours()
    {
        return $this->hasMany(Tour::class);
    }

    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class);
    }
}
