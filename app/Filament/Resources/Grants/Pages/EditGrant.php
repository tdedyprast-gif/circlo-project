<?php

namespace App\Filament\Resources\Grants\Pages;

use App\Filament\Resources\Grants\GrantResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditGrant extends EditRecord
{
    protected static string $resource = GrantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
