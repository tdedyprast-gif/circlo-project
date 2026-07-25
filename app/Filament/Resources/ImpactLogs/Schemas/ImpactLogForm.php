<?php

namespace App\Filament\Resources\ImpactLogs\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ImpactLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('impact_indicator_id')
                    ->required()
                    ->numeric(),
                TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                TextInput::make('verified_by_facilitator_id')
                    ->numeric(),
                TextInput::make('pre_program_value')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('post_program_value')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                Textarea::make('evidence_file_path')
                    ->columnSpanFull(),
                DateTimePicker::make('verified_at'),
            ]);
    }
}
