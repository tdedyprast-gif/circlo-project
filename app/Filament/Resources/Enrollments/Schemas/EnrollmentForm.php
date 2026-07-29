<?php

namespace App\Filament\Resources\Enrollments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Schemas\Schema;
use App\Models\User;
use App\Models\Enrollment;
use Illuminate\Database\Eloquent\Model;
use Closure;
use Filament\Notifications\Notification;

class EnrollmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->multiple()
                    ->relationship('user', 'name')
                    ->required()
                    ->live(),
                Select::make('cohort_id')
                    ->label('Cohort / Batch')
                    ->relationship('cohort', 'cohort_name') // Menampilkan nama cohort
                    ->required()
                    ->searchable()
                    ->preload()
                    ->rule(function ($get, ?Model $record) {
                        return function (string $attribute, $value, Closure $fail) use ($get, $record) {
                            $userId = $get('user_id');

                            $isDuplicate = Enrollment::where('user_id', $userId)
                                ->where('cohort_id', $value)
                                ->when($record, fn($query) => $query->where('id', '!=', $record->id))
                                ->exists();

                            if ($isDuplicate) {
                                $user = User::find($userId);
                                $namaPeserta = $user ? $user->name : 'Peserta ini';

                                // Kirim pop-up notification
                                Notification::make()
                                    ->title('Duplikasi Pendaftaran')
                                    ->body("Peringatan: {$namaPeserta} sudah terdaftar di Cohort / Course tersebut.")
                                    ->danger()
                                    ->send();

                                // Tetap gagalkan validasi agar tidak tersimpan
                                $fail("{$namaPeserta} sudah terdaftar di Cohort / Course tersebut.");
                            }
                        };
                    }),
                Select::make('status')
                    ->options([
                        'ENROLLED' => 'E n r o l l e d',
                        'IN_PROGRESS' => 'I n  p r o g r e s s',
                        'COMPLETED' => 'C o m p l e t e d',
                        'DROPPED' => 'D r o p p e d',
                    ])
                    ->default('ENROLLED')
                    ->required(),
                DateTimePicker::make('enrolled_at')
                    ->required(),
                DateTimePicker::make('completed_at'),
            ]);
    }
}
