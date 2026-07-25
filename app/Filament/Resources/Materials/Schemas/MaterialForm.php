<?php

namespace App\Filament\Resources\Materials\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Get;
use Filament\Schemas\Schema;

class MaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Menggunakan relasi agar muncul dropdown nama sesi
                Select::make('course_sessions_id')
                    ->label('Course Session')
                    ->relationship(name: 'courseSession', titleAttribute: 'title')
                    ->required()
                    ->searchable()
                    ->preload(),

                TextInput::make('title')
                    ->required()
                    ->maxLength(255),

                // Menambahkan live() agar form interaktif
                Select::make('content_type')
                    ->options([
                        'VIDEO' => 'Video', 
                        'PDF' => 'PDF', 
                        'TEXT' => 'Text', 
                        'AUDIO' => 'Audio'
                    ])
                    ->required()
                    ->live(), 

                // Menyesuaikan visibilitas berdasarkan content_type
                TextInput::make('content_url')
                    ->label('Content URL')
                    ->url()
->visible(fn ($get) => in_array($get('content_type'), ['VIDEO', 'PDF', 'AUDIO']))
->required(fn ($get) => in_array($get('content_type'), ['VIDEO', 'PDF', 'AUDIO']))                    ->columnSpanFull(),

                // Mengganti Textarea dengan RichEditor
                RichEditor::make('body_text')
                    ->label('Body Text / Description')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'bulletList', 'orderedList', 'link', 'h2', 'h3',
                    ])
                    ->columnSpanFull(),

                Toggle::make('is_required')
                    ->default(true)
                    ->required(),

                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(1),
            ]);
    }
}