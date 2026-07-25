<?php

namespace App\Filament\Resources\CourseSessions\Pages;

use App\Filament\Resources\CourseSessions\CourseSessionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewCourseSession extends ViewRecord
{
    protected static string $resource = CourseSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
