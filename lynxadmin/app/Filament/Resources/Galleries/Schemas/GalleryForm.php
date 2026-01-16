<?php

namespace App\Filament\Resources\Galleries\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;

class GalleryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->label('Gallery Title')
                    ->required()
                    ->maxLength(255),

                FileUpload::make('image')
                    ->label('Gallery Image')
                    ->image()
                    ->directory('galleries')
                    ->disk('public')
                    ->visibility('public')
                    ->required(),

                // Select::make('category_id')
                //     ->label('Category')
                //     ->relationship('category', 'name')
                //     ->searchable()
                //     ->preload(),

                // Forms\Components\Toggle::make('is_featured')
                //     ->label('Featured')
                //     ->default(false),
            ]);
    }
}
