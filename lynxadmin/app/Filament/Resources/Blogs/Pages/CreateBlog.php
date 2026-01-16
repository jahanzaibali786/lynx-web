<?php

namespace App\Filament\Resources\Blogs\Pages;

use App\Filament\Resources\Blogs\BlogResource;
use Filament\Resources\Pages\CreateRecord;
use Str;
use Illuminate\Support\Carbon;

class CreateBlog extends CreateRecord
{
    protected static string $resource = BlogResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Auto-generate slug if empty
        if (empty($data['slug']) && !empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }

        if (($data['status'] ?? null) === 'published' && empty($data['published_at'])) {
            $data['published_at'] = Carbon::now();
        }

        // Auto-generate excerpt if empty
        if (empty($data['excerpt']) && !empty($data['content'])) {
            // Strip HTML and limit to 150 characters (you can adjust length)
            $data['excerpt'] = mb_substr(strip_tags($data['content']), 0, 150);
        }

        return $data;
    }
}
