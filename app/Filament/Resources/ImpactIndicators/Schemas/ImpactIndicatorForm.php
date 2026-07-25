<?php

namespace App\Filament\Resources\ImpactIndicators\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ImpactIndicatorForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('grant_id')
                    ->relationship('grant', 'grant_name')
                    ->required(),
                TextInput::make('metric_name')
                    ->required(),
                Select::make('metric_type')
                    ->options([
            'PERCENTAGE' => 'P e r c e n t a g e',
            'CURRENCY' => 'C u r r e n c y',
            'NUMERIC' => 'N u m e r i c',
            'BOOLEAN' => 'B o o l e a n',
        ])
                    ->required(),
                TextInput::make('target_value')
                    ->required()
                    ->numeric(),
            ]);
    }
}
