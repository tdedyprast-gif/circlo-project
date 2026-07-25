<?php

namespace App\Filament\Resources\SessionCompletions\Pages;

use App\Filament\Resources\SessionCompletions\SessionCompletionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditSessionCompletion extends EditRecord
{
    protected static string $resource = SessionCompletionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
