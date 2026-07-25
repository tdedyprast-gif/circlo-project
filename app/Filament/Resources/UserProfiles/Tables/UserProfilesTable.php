<?php

namespace App\Filament\Resources\UserProfiles\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class UserProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->searchable(),
                TextColumn::make('gender')
                    ->badge(),
                TextColumn::make('birth_date')
                    ->date()
                    ->sortable(),
                TextColumn::make('province_id')
                    ->searchable(),
                TextColumn::make('regency_id')
                    ->searchable(),
                TextColumn::make('district_id')
                    ->searchable(),
                TextColumn::make('economic_status')
                    ->badge(),
                TextColumn::make('primary_occupation')
                    ->searchable(),
                IconColumn::make('is_disabled')
                    ->boolean(),
                TextColumn::make('disability_type')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
