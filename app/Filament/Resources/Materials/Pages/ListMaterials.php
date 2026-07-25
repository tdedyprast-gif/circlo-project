<?php

namespace App\Filament\Resources\Materials\Pages;

use App\Enums\MaterialType;
use App\Filament\Resources\Materials\MaterialResource;
use App\Models\CourseSession;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\View\View;

class ListMaterials extends ListRecords
{
    protected static string $resource = MaterialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('create_wizard')
                ->label('Buat Materi & Tugas (Wizard)')
                ->icon('heroicon-o-plus')
                ->modalHeading('Wizard Tambah Materi & Tugas') // ✅ Ganti ke modalHeading
                ->modalWidth('3xl')
                ->modalSubmitAction(false) // Menyembunyikan tombol submit bawaan Filament
                ->modalContent(function (): View {
                    $sessions = CourseSession::with('course')->get();
                    $materialTypes = MaterialType::cases();

                    return view('admin.wizards.material-assignment-modal', compact('sessions', 'materialTypes'));
                }),
        ];
    }
}