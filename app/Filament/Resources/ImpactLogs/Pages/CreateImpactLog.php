<?php

namespace App\Filament\Resources\ImpactLogs\Pages;

use App\Filament\Resources\ImpactLogs\ImpactLogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateImpactLog extends CreateRecord
{
    protected static string $resource = ImpactLogResource::class;
}
