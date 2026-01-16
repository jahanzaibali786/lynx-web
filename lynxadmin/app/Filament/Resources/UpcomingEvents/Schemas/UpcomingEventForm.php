<?php

namespace App\Filament\Resources\UpcomingEvents\Schemas;

use Filament\Schemas\Schema;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;

class UpcomingEventForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                TextInput::make('title')->required(),

                DatePicker::make('date')->required(),

                TimePicker::make('start_time')
                    ->label('Start Time')
                    ->helperText('If start and end time is empty "All Day" will be considered'),
                TimePicker::make('end_time')->label('End Time'),

                TextInput::make('location')->required(),

                FileUpload::make('images')
                    ->label('Event Images')
                    ->multiple()
                    ->maxFiles(10)
                    ->image()
                    ->directory('events')
                    ->disk('public')
                    ->visibility('public')
                    ->helperText('You must upload at least 3 images (up to 10). Images must be square (e.g., 500x500 or 800x800).')
                    ->imageResizeMode('cover')
                    ->imageCropAspectRatio('1:1')
                    ->panelLayout('grid') // ✅ makes previews horizontal
                    ->required()
                    ->rules(['array', 'min:3']) // ✅ at least 3 images required
                    ->validationMessages([
                        'min' => 'Please upload at least 3 images.',
                    ])
                    ->columnSpanFull(),

                RichEditor::make('description')
                    ->label('Content')
                    ->required()
                    ->columnSpanFull()
                    ->extraAttributes([
                        'style' => 'min-height: 400px;',
                    ]),
            ]);
    }
}
