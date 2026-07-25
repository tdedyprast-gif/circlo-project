<?php

namespace App\Filament\Resources\ImpactIndicators\Pages;

use App\Filament\Resources\ImpactIndicators\ImpactIndicatorResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditImpactIndicator extends EditRecord
{
    protected static string $resource = ImpactIndicatorResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
