<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = ['card_id', 'feature_icon', 'feature_heading', 'feature_paragraph'];

    public function card()
    {
        return $this->belongsTo(ProductCard::class, 'card_id');
    }
}

