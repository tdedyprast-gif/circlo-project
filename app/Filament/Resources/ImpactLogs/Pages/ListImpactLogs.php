<?php

namespace App\Filament\Resources\ImpactLogs\Pages;

use App\Filament\Resources\ImpactLogs\ImpactLogResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListImpactLogs extends ListRecords
{
    protected static string $resource = ImpactLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
