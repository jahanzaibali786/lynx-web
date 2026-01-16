<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    protected $fillable = ['name', 'monthly_price', 'yearly_discount'];

    public function features()
    {
        return $this->belongsToMany(PricingFeature::class, 'pricing_feature_plan')
            ->withPivot('is_enabled')
            ->withTimestamps();
    }

    // Computed yearly price
    public function getYearlyPriceAttribute(): float
    {
        $base = $this->monthly_price * 12;
        return $base - ($base * ($this->yearly_discount / 100));
    }
}
