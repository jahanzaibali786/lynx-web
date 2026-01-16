<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCard extends Model
{
    protected $fillable = ['product_id', 'heading', 'paragraph', 'icon'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function features()
    {
        return $this->hasMany(Feature::class, 'card_id');
    }
}
