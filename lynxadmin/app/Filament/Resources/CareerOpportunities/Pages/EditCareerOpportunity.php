<?php

namespace App\Filament\Resources\CareerOpportunities\Pages;

use App\Filament\Resources\CareerOpportunities\CareerOpportunityResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCareerOpportunity extends EditRecord
{
    protected static string $resource = CareerOpportunityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('save')
                ->label('Save Changes')
                ->action('save')
                ->color('success'),
            Actions\DeleteAction::make(),
        ];
    }

    protected function getFormActions(): array
    {
        return [
            // Remove actions from bottom
        ];
    }
}

