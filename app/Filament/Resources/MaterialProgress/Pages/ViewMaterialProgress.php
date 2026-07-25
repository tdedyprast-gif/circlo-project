<?php

namespace App\Filament\Resources\MaterialProgress\Pages;

use App\Filament\Resources\MaterialProgress\MaterialProgressResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewMaterialProgress extends ViewRecord
{
    protected static string $resource = MaterialProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
