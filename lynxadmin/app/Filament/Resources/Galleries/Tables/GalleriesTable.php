<?php

namespace App\Filament\Resources\Galleries\Tables;

use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
// use Filament\Tables\Columns\DateTimeColumn;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;

class GalleriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('title')->searchable()->sortable(),
                ImageColumn::make('image')->label('Gallery Image')->disk('public')->visibility('public'),
                // DateTimeColumn::make('created_at')->label('Created')->sortable(),
            ])
            ->filters([
                // Tables\Filters\TrashedFilter::make(), // optional if using soft deletes
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
