<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['product_heading', 'product_paragraph'];

    public function cards()
    {
        return $this->hasMany(ProductCard::class, 'product_id');
    }
}
