<?php

namespace App\Filament\Resources\Enrollments\Tables;


use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EnrollmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Peserta')
                    ->searchable(),
                
                // 1. Ubah cohort.id menjadi cohort.cohort_name agar menampilkan nama, bukan angka
                TextColumn::make('cohort.cohort_name')
                    ->label('Cohort / Batch')
                    ->searchable(),

                // 2. Gunakan dotted notation untuk mengambil data Course dari relasi Cohort
                // (Ganti 'title' dengan 'course_name' jika kolom di tabel courses Anda bernama course_name)
                TextColumn::make('cohort.course.title')
                    ->label('Course Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('status')
                    ->badge(),
                
                TextColumn::make('enrolled_at')
                    ->dateTime()
                    ->sortable(),
                
                TextColumn::make('completed_at')
                    ->dateTime()
                    ->sortable(),
                
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ]);
    }
}