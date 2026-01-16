<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Addon extends Model
{
    protected $fillable = [
        'category', 
        'name',
        'icon',
        'short_detail'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(AddOnCategories::class, 'category');
    }

    public function categoryRelation(): BelongsTo
    {
        return $this->belongsTo(AddOnCategories::class, 'category');
    }
}
