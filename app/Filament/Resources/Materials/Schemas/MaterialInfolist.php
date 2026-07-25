<?php

namespace App\Filament\Resources\Materials\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class MaterialInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('course_sessions_id')
                    ->numeric(),
                TextEntry::make('title'),
                TextEntry::make('content_type')
                    ->badge(),
                TextEntry::make('content_url')
                    ->placeholder('-')
                    ->columnSpanFull(),
                TextEntry::make('body_text')
                    ->placeholder('-')
                    ->columnSpanFull(),
                IconEntry::make('is_required')
                    ->boolean(),
                TextEntry::make('order')
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
