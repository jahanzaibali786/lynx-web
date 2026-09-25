<?php

namespace App\Filament\Resources\CareerOpportunities\Pages;

use App\Filament\Resources\CareerOpportunities\CareerOpportunityResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCareerOpportunity extends CreateRecord
{
    protected static string $resource = CareerOpportunityResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}

