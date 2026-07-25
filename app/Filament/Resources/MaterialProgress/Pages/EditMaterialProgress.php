<?php

namespace App\Filament\Resources\MaterialProgress\Pages;

use App\Filament\Resources\MaterialProgress\MaterialProgressResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditMaterialProgress extends EditRecord
{
    protected static string $resource = MaterialProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
