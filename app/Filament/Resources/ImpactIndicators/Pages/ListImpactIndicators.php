<?php

namespace App\Filament\Resources\ImpactIndicators\Pages;

use App\Filament\Resources\ImpactIndicators\ImpactIndicatorResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListImpactIndicators extends ListRecords
{
    protected static string $resource = ImpactIndicatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
