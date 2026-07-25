<?php

namespace App\Filament\Resources\UserProfiles\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class UserProfileInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('gender')
                    ->badge(),
                TextEntry::make('birth_date')
                    ->date()
                    ->placeholder('-'),
                TextEntry::make('province_id'),
                TextEntry::make('regency_id'),
                TextEntry::make('district_id'),
                TextEntry::make('address_detail')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('economic_status')
                    ->badge(),
                TextEntry::make('primary_occupation')
                    ->placeholder('-'),
                IconEntry::make('is_disabled')
                    ->boolean(),
                TextEntry::make('disability_type')
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
