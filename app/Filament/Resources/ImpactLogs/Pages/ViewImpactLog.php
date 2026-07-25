<?php

namespace App\Filament\Resources\ImpactLogs\Pages;

use App\Filament\Resources\ImpactLogs\ImpactLogResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewImpactLog extends ViewRecord
{
    protected static string $resource = ImpactLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
