<?php

namespace App\Filament\Resources\MaterialProgress\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MaterialProgressForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('enrollment_id')
                    ->relationship('enrollment', 'id')
                    ->required(),
                Select::make('material_id')
                    ->relationship('material', 'title')
                    ->required(),
                Toggle::make('is_completed')
                    ->required(),
                DateTimePicker::make('completed_at'),
            ]);
    }
}
