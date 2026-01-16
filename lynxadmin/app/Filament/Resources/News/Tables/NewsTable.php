<?php

namespace App\Filament\Resources\News\Tables;

use Filament\Tables;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class NewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->disk('public')
                    ->visibility('public')
                    ->square(),

                Tables\Columns\TextColumn::make('title')
                    ->label('Title')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('final_excerpt')
                    ->label('Short Description')
                    ->limit(50),

                Tables\Columns\TextColumn::make('published_at')
                    ->label('Published')
                    ->date(),
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
