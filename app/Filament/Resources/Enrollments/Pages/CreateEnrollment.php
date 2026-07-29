<?php

namespace App\Filament\Resources\Enrollments\Pages;

use App\Filament\Resources\Enrollments\EnrollmentResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Validation\ValidationException;

class CreateEnrollment extends CreateRecord
{
    protected static string $resource = EnrollmentResource::class;

    // Tambahkan method ini untuk menangkap error dan memunculkan SweetAlert
    protected function onValidationError(ValidationException $exception): void
    {
        // Ambil pesan error pertama (misal: "User ini sudah terdaftar...")
        $errorMessage = collect($exception->errors())->flatten()->first();

        // Panggil SweetAlert menggunakan JavaScript
        $this->js("
            Swal.fire({
                icon: 'error',
                title: 'Gagal Menyimpan!',
                text: '{$errorMessage}',
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#ef4444' // Warna merah yang senada dengan error
            });
        ");
    }
}