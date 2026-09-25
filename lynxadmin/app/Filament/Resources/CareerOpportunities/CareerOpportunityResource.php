<?php

namespace App\Filament\Resources\CareerOpportunities;

use App\Filament\Resources\CareerOpportunities\Pages\CreateCareerOpportunity;
use App\Filament\Resources\CareerOpportunities\Pages\EditCareerOpportunity;
use App\Filament\Resources\CareerOpportunities\Pages\ListCareerOpportunities;
use App\Filament\Resources\CareerOpportunities\Schemas\CareerOpportunityForm;
use App\Filament\Resources\CareerOpportunities\Tables\CareerOpportunityTable;
use App\Models\CareerOpportunity;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CareerOpportunityResource extends Resource
{
    protected static ?string $model = CareerOpportunity::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::Briefcase;

    protected static ?string $navigationLabel = 'Career Opportunities';

    protected static ?string $modelLabel = 'Career Opportunity';

    protected static ?string $pluralModelLabel = 'Career Opportunities';

    public static function form(Schema $schema): Schema
    {
        return CareerOpportunityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CareerOpportunityTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCareerOpportunities::route('/'),
            'create' => CreateCareerOpportunity::route('/create'),
            'edit' => EditCareerOpportunity::route('/{record}/edit'),
        ];
    }
}

