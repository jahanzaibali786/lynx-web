<?php

namespace App\Filament\Resources\AdmissionApplications\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\DateTimeColumn;

class AdmissionApplicationsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('first_name')->label('First Name')->sortable()->searchable(),
                TextColumn::make('last_name')->label('Last Name')->sortable()->searchable(),
                TextColumn::make('phone')->label('Phone')->sortable(),
                TextColumn::make('child_name')->label('Child Name')->sortable()->searchable(),
                TextColumn::make('gender')->sortable(),
                TextColumn::make('branch')->sortable(),
                TextColumn::make('class')->sortable(),
                // DateTimeColumn::make('created_at')->label('Created')->sortable(),
            ])
            ->filters([
                // You can add filters like gender, branch, class etc.
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
