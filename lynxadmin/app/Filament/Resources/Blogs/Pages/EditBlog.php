<?php

namespace App\Filament\Resources\Blogs\Pages;

use App\Filament\Resources\Blogs\BlogResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use Str;

class EditBlog extends EditRecord
{
    protected static string $resource = BlogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        if (!empty($data['title'])) {
            $data['slug'] = Str::slug($data['title']);
        }
        return $data;
    }

}
