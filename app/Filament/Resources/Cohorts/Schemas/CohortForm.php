<?php

namespace App\Filament\Resources\Cohorts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CohortForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_id')
                    ->relationship('course', 'title')
                    ->required(),
                Select::make('facilitator_id')
                    ->relationship('facilitator', 'name')
                    ->required(),
                TextInput::make('cohort_name')
                    ->required(),
                TextInput::make('max_capacity')
                    ->required()
                    ->numeric()
                    ->default(30),
            ]);
    }
}
