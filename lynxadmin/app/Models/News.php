<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class News extends Model
{
    protected $fillable = [
        'title',
        'image',
        'excerpt',
        'description',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'date',
    ];

    protected $appends = ['image_url', 'final_excerpt'];

    // Full image URL
    public function getImageUrlAttribute(): ?string
    {
        return $this->image
            ? Storage::disk('public')->url($this->image)
            : null;
    }

    // Smart excerpt: if empty, take first 150 chars of description (without tags)
    public function getFinalExcerptAttribute(): string
    {
        if ($this->excerpt && trim($this->excerpt) !== '') {
            return $this->excerpt;
        }

        // strip tags & shorten
        return Str::limit(strip_tags($this->description), 150, '...');
    }
}
