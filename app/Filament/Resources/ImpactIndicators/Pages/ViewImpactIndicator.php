<?php

namespace App\Filament\Resources\ImpactIndicators\Pages;

use App\Filament\Resources\ImpactIndicators\ImpactIndicatorResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewImpactIndicator extends ViewRecord
{
    protected static string $resource = ImpactIndicatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
