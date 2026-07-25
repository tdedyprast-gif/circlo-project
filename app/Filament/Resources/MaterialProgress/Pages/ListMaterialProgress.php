<?php

namespace App\Filament\Resources\MaterialProgress\Pages;

use App\Filament\Resources\MaterialProgress\MaterialProgressResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListMaterialProgress extends ListRecords
{
    protected static string $resource = MaterialProgressResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
