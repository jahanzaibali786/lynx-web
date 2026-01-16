<?php

namespace App\Filament\Resources\Blogs\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;
use Filament\Forms\Components\RichEditor;

class BlogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('title')
                    ->required(),
                TextInput::make('slug'),
                FileUpload::make('featured_image')
                    ->image()
                    ->disk('public')
                    ->visibility('public'),
                RichEditor::make('content')
                    ->required()
                    ->columnSpanFull()
                    ->extraAttributes([
                        'style' => 'min-height: 400px;'
                    ]),
                Textarea::make('excerpt')
                    ->default(null)
                    ->columnSpanFull(),
                Select::make('status')
                    ->options(['draft' => 'Draft', 'published' => 'Published'])
                    ->default('draft')
                    ->required(),
                DateTimePicker::make('published_at'),
            ]);
    }
}
