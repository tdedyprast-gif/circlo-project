<?php

namespace App\Filament\Resources\Grants\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class GrantInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('donor.id')
                    ->label('Donor'),
                TextEntry::make('grant_name'),
                TextEntry::make('code'),
                TextEntry::make('total_funding_amount')
                    ->numeric(),
                TextEntry::make('cost_per_beneficiary_target')
                    ->numeric(),
                TextEntry::make('target_beneficiaries_count')
                    ->numeric(),
                TextEntry::make('start_date')
                    ->date(),
                TextEntry::make('end_date')
                    ->date(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
