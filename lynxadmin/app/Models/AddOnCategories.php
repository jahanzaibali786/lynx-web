<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AddOnCategories extends Model
{
    protected $fillable = ['category_name'];

    // Use custom table name if needed
    protected $table = 'addoncategories';

    public function addons(): HasMany
    {
        return $this->hasMany(Addon::class, 'category');
    }
}