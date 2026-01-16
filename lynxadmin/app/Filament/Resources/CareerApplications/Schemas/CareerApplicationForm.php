<?php

namespace App\Filament\Resources\CareerApplications\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;

class CareerApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->schema([
            TextInput::make('name')
                ->label('Full Name')
                ->required()
                ->maxLength(255),

            TextInput::make('email')
                ->label('Email')
                ->email()
                ->required()
                ->maxLength(255),

            TextInput::make('phone')
                ->label('Phone')
                ->tel()
                ->required()
                ->maxLength(20),

            Select::make('career')
                ->label('Career')
                ->options([
                    'developer' => 'Developer',
                    'designer' => 'Designer',
                    'manager' => 'Manager',
                    'other'    => 'Other',
                ])
                ->required(),

            Textarea::make('message')
                ->label('Message')
                ->rows(4)
                ->nullable(),

            FileUpload::make('cv')
                ->label('Upload CV')
                ->disk('public')       // adjust storage disk
                ->directory('cvs')     // folder in storage/app/public/cvs
                ->visibility('public')
                ->maxSize(10240)       // 10 MB
                ->required(false)
                // ->downloadable()
                // ->openable()
                // ->preserveFilenames(),
        ]);
    }
}
