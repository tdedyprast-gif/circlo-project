<?php

namespace App\Filament\Resources\CourseSessions\RelationManagers;

use Filament\Forms;
use Filament\Schemas\Schema; // <-- Gunakan Schema
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class AssignmentsRelationManager extends RelationManager
{
    protected static string $relationship = 'assignments';

    public function form(Schema $schema): Schema // <-- Ubah parameter di sini
    {
        return $schema
            ->components([ // <-- Gunakan components()
                Forms\Components\TextInput::make('title')
                    ->label('Judul Tugas')
                    ->required()
                    ->maxLength(255),

                Forms\Components\RichEditor::make('description')
                    ->label('Instruksi Tugas')
                    ->required()
                    ->columnSpanFull(),

                Forms\Components\DateTimePicker::make('due_date')
                    ->label('Tenggat Waktu (Deadline)')
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title')->label('Judul Tugas')->searchable(),
                Tables\Columns\TextColumn::make('due_date')->label('Deadline')->dateTime()->sortable(),
            ]);
    }
}