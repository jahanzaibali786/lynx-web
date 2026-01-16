<?php

namespace App\Filament\Resources\GalleryImages\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;

class GalleryImageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('gallery_id')
                    ->label('Gallery')
                    ->relationship('gallery', 'title') // assumes Gallery model has 'title'
                    ->required()
                    ->searchable()
                    ->preload(),

                FileUpload::make('image')
                    ->label('Image')
                    ->image()
                    ->directory('gallery-images')
                    ->visibility('public')
                    ->disk('public')
                    ->required(),

                // FileUpload::make('images')
                //     ->label('Images')
                //     ->image()
                //     ->multiple() // allow multiple uploads
                //     ->directory('gallery-images')
                //     ->visibility('public')
                //     ->disk('public')
                //     ->required(),
            ]);
    }
}
