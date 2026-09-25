<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CareerOpportunity extends Model
{
    protected $fillable = [
        'position_name',
        'short_description',
        'full_description',
        'detail_pdf',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected $appends = ['pdf_url'];

    // Full PDF URL
    public function getPdfUrlAttribute(): ?string
    {
        return $this->detail_pdf
            ? Storage::disk('public')->url($this->detail_pdf)
            : null;
    }
}

