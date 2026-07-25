<?php

namespace App\Filament\Resources\SessionCompletions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class SessionCompletionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('enrollment_id')
                    ->relationship('enrollment', 'id')
                    ->required(),
                TextInput::make('course_sessions_id')
                    ->required()
                    ->numeric(),
                Select::make('status')
                    ->options(['IN_PROGRESS' => 'I n  p r o g r e s s', 'COMPLETED' => 'C o m p l e t e d'])
                    ->default('IN_PROGRESS')
                    ->required(),
                DateTimePicker::make('completed_at'),
            ]);
    }
}
