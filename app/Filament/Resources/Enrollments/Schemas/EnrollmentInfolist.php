<?php

namespace App\Filament\Resources\Enrollments\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class EnrollmentInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('user.name')
                    ->label('User'),
                TextEntry::make('course.title')
                    ->label('Course'),
                TextEntry::make('cohort.id')
                    ->label('Cohort')
                    ->placeholder('-'),
                TextEntry::make('status')
                    ->badge(),
                TextEntry::make('enrolled_at')
                    ->dateTime(),
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
