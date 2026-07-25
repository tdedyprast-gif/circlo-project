<?php

namespace App\Filament\Resources\ImpactLogs\Pages;

use App\Filament\Resources\ImpactLogs\ImpactLogResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditImpactLog extends EditRecord
{
    protected static string $resource = ImpactLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
