<?php

namespace App\Filament\Resources\CourseSessions\RelationManagers;

use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class MaterialsRelationManager extends RelationManager
{
    protected static string $relationship = 'materials';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Judul Materi')
                    ->required()
                    ->maxLength(255),

                Forms\Components\Select::make('content_type')
                    ->label('Tipe Konten')
                    ->options([
                        'VIDEO' => 'Video',
                        'PDF' => 'PDF',
                        'TEXT' => 'Teks',
                        'AUDIO' => 'Audio',
                    ])
                    ->required()
                    ->live(),

                Forms\Components\TextInput::make('content_url')
                    ->label('URL Konten (YouTube/Link)')
                    ->url()
                    ->maxLength(65535),

                Forms\Components\RichEditor::make('body_text')
                    ->label('Isi Teks / Deskripsi')
                    ->columnSpanFull(),

                Forms\Components\Toggle::make('is_required')
                    ->label('Wajib Dibaca/Ditonton')
                    ->default(true),

                Forms\Components\TextInput::make('order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(1)
                    ->required(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('order')
                    ->label('No')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Materi')
                    ->searchable(),
                Tables\Columns\BadgeColumn::make('content_type')
                    ->label('Tipe'),
                Tables\Columns\IconColumn::make('is_required')
                    ->label('Wajib')
                    ->boolean(),
            ])
            ->filters([
                // tambahkan filter jika perlu
            ]);
    }
}
