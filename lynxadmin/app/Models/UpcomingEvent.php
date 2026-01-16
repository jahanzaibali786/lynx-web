<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UpcomingEvent extends Model
{
    protected $fillable = [
        'title',
        'date',
        'start_time',
        'end_time',
        'location',
        'images',
        'description',
    ];

    protected $casts = [
        'date' => 'date',
        'start_time' => 'string',
        'end_time' => 'string',
        'images' => 'array',
    ];

    protected $appends = ['main_image_url', 'image_urls', 'time_label'];

    // First image = main image
    public function getMainImageUrlAttribute(): ?string
    {
        $images = $this->images ?? [];
        return count($images)
            ? Storage::disk('public')->url($images[0])
            : null;
    }


    // All image URLs
    public function getImageUrlsAttribute(): array
    {
        $images = $this->images ?? [];
        return array_map(fn($img) => Storage::disk('public')->url($img), $images);
    }

    // Time label (either range or "All Day")
    public function getTimeLabelAttribute(): string
    {
        return ($this->start_time && $this->end_time)
            ? "{$this->start_time} - {$this->end_time}"
            : "All Day";
    }
}
