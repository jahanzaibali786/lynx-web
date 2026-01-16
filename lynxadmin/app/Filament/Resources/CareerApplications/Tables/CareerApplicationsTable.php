<?php

namespace App\Filament\Resources\CareerApplications\Tables;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;

class CareerApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Name')->sortable()->searchable(),
                TextColumn::make('email')->label('Email')->sortable()->searchable(),
                TextColumn::make('phone')->label('Phone'),
                TextColumn::make('career')->label('Career'),
                TextColumn::make('message')->label('Message')->limit(50),

                // CV column with download link
                TextColumn::make('cv')
                    ->label('CV')
                    ->formatStateUsing(fn($state) => $state ? "<a href='" . asset('storage/' . $state) . "' target='_blank'>Download</a>" : '-')
                    ->html(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
