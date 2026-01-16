<?php

namespace App\Filament\Resources\AdmissionApplications\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;

class AdmissionApplicationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('first_name')->label('First Name')->required(),
                TextInput::make('last_name')->label('Last Name')->required(),
                TextInput::make('phone')->label('Phone')->required(),
                TextInput::make('address')->label('Address')->required(),
                TextInput::make('child_name')->label('Child Name')->required(),
                Select::make('gender')->label('Gender')
                    ->options([
                        'male' => 'Male',
                        'female' => 'Female',
                        'other' => 'Other',
                    ])->required(),
                TextInput::make('branch')->label('Branch')->required(),
                TextInput::make('class')->label('Class')->required(),
                Textarea::make('more_about_child')->label('More About Child')->rows(4),
            ]);
    }
}
