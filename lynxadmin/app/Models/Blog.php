<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class Blog extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'content',
        'featured_image',
        'excerpt',
        'status',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime'
    ];

    // Add a computed attribute for JSON serialization
    protected $appends = ['featured_image_url', 'published_at_formatted'];

    public function getFeaturedImageUrlAttribute(): ?string
    {
        if (!$this->featured_image) {
            return null;
        }

        // Use the correct disk
        return Storage::disk('public')->url($this->featured_image);
    }

    // New accessor for formatted date
    public function getPublishedAtFormattedAttribute(): ?string
    {
        if (!$this->published_at) {
            return null;
        }

        return Carbon::parse($this->published_at)->format('F j, Y'); // e.g., November 15, 2023
    }
}