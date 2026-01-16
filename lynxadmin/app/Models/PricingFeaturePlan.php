<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class PricingFeaturePlan extends Pivot
{
    protected $table = 'pricing_feature_plan';
    protected $fillable = ['pricing_plan_id', 'pricing_feature_id', 'is_enabled'];
    public $incrementing = true;
}
