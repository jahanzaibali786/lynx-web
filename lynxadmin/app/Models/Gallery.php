<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Gallery extends Model
{
    protected $fillable = ['title', 'description', 'image'];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    public function images()
    {
        return $this->hasMany(GalleryImage::class);
    }
}