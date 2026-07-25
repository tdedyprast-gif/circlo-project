<?php

namespace App\Filament\Resources\Grants\Pages;

use App\Filament\Resources\Grants\GrantResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewGrant extends ViewRecord
{
    protected static string $resource = GrantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
