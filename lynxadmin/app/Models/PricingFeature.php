<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingFeature extends Model
{
    protected $fillable = ['name'];

    public function plans()
    {
        return $this->belongsToMany(PricingPlan::class, 'pricing_feature_plan')
            ->withPivot('is_enabled')
            ->withTimestamps();
    }
}
