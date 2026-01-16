<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Forms;
use Filament\Schemas\Schema;

class NewsForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\FileUpload::make('image')
                    ->label('News Image')
                    ->image()
                    ->directory('news')
                    ->disk('public')
                    ->visibility('public')
                    ->required(),

                Forms\Components\Textarea::make('excerpt')
                    ->label('Short Description')
                    ->rows(3)
                    ->columnSpanFull()
                    ->helperText('If empty, the system will auto-generate from description.'),

                Forms\Components\RichEditor::make('description')
                    ->label('Description')
                    // ->required()
                    ->columnSpanFull()
                    ->extraAttributes(['style' => 'min-height: 400px;']),

                Forms\Components\DatePicker::make('published_at')
                    ->label('Publish Date')
                    ->default(now()),
            ]);
    }
}
