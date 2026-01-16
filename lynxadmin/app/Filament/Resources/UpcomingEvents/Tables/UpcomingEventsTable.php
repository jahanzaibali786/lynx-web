<?php

namespace App\Filament\Resources\UpcomingEvents\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Storage;


class UpcomingEventsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')->searchable()->sortable(),
                TextColumn::make('date')->date(),
                TextColumn::make('time_label')
                    ->label('Time'),
                TextColumn::make('location'),
                ImageColumn::make('images')
                    ->label('Images')
                    ->circular()
                    ->disk('public')
                    ->visibility('public')
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
