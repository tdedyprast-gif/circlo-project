<?php

namespace App\Filament\Resources\SessionCompletions\Pages;

use App\Filament\Resources\SessionCompletions\SessionCompletionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSessionCompletions extends ListRecords
{
    protected static string $resource = SessionCompletionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
