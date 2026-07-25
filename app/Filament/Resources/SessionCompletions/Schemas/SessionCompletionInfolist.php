<?php

namespace App\Filament\Resources\SessionCompletions\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class SessionCompletionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('enrollment.id')
                    ->label('Enrollment'),
                TextEntry::make('course_sessions_id')
                    ->numeric(),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('completed_at')
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
