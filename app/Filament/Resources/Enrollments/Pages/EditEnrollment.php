<?php

namespace App\Filament\Resources\Enrollments\Pages;

use App\Filament\Resources\Enrollments\EnrollmentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Notifications\Notification;
use Illuminate\Validation\ValidationException;

class EditEnrollment extends EditRecord
{
    protected static string $resource = EnrollmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // Tangkap error dan jadikan pop up notification
    protected function onValidationError(ValidationException $exception): void
    {
        $errorMessage = collect($exception->errors())->flatten()->first();

        Notification::make()
            ->title('Data Gagal Disimpan')
            ->body($errorMessage)
            ->warning() // Anda bisa menggunakan warning() (kuning) atau danger() (merah)
            ->send();
    }
}