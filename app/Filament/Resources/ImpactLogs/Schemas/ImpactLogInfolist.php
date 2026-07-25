<?php

namespace App\Filament\Resources\ImpactLogs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ImpactLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('impact_indicator_id')
                    ->numeric(),
                TextEntry::make('user_id')
                    ->numeric(),
                TextEntry::make('verified_by_facilitator_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('pre_program_value')
                    ->numeric(),
                TextEntry::make('post_program_value')
                    ->numeric(),
                TextEntry::make('evidence_file_path')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('verified_at')
                    ->dateTime()
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
