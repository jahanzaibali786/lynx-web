<?php

namespace App\Filament\Resources\CareerApplications;

use App\Filament\Resources\CareerApplications\Pages\ListCareerApplications;
use App\Filament\Resources\CareerApplications\Schemas\CareerApplicationForm;
use App\Filament\Resources\CareerApplications\Tables\CareerApplicationsTable;
use App\Models\CareerApplication;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Filament\Support\Icons\Heroicon;
use BackedEnum;
use App\Filament\Resources\CareerApplications\Pages\CreateCareerApplication;
use App\Filament\Resources\CareerApplications\Pages\EditCareerApplication;

class CareerApplicationResource extends Resource
{
    protected static ?string $model = CareerApplication::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBriefcase;

    public static function form(Schema $schema): Schema
    {
        return CareerApplicationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CareerApplicationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCareerApplications::route('/'),
            'create' => CreateCareerApplication::route('/create'),
            'edit' => EditCareerApplication::route('/{record}/edit'),
        ];
    }
}
