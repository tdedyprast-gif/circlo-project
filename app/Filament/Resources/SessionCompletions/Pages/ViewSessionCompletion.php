<?php

namespace App\Filament\Resources\SessionCompletions\Pages;

use App\Filament\Resources\SessionCompletions\SessionCompletionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewSessionCompletion extends ViewRecord
{
    protected static string $resource = SessionCompletionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
