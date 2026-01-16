<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


// GalleryImage.php
class GalleryImage extends Model
{
    protected $fillable = ['gallery_id', 'image'];

    protected $appends = ['image_url'];

    public function getImageUrlAttribute(): ?string
    {
        return $this->image ? Storage::disk('public')->url($this->image) : null;
    }

    public function gallery()
    {
        return $this->belongsTo(Gallery::class);
    }
}
