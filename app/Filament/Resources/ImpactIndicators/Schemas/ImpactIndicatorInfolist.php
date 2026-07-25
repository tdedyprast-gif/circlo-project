<?php

namespace App\Filament\Resources\ImpactIndicators\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ImpactIndicatorInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('grant.id')
                    ->label('Grant'),
                TextEntry::make('metric_name'),
                TextEntry::make('metric_type')
                    ->badge(),
                TextEntry::make('target_value')
                    ->numeric(),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
