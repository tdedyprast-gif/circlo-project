<?php

namespace App\Filament\Resources\Cohorts\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class CohortInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('course.title')
                    ->label('Course'),
                TextEntry::make('facilitator.name')
                    ->label('Facilitator'),
                TextEntry::make('cohort_name'),
                TextEntry::make('max_capacity')
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
