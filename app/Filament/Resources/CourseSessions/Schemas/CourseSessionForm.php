<?php

namespace App\Filament\Resources\CourseSessions\Schemas;

use Filament\Forms\Components\RichEditor\RichContentAttribute;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class CourseSessionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_id')
                    ->relationship('course', 'title')
                    ->required(),
                TextInput::make('title')
                    ->required(),
                RichEditor::make('description')
                    ->label('Description')
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ])
                    ->columnSpanFull() // Agar editor memanjang penuh seperti di WordPress
                    ->required(),
                TextInput::make('order')
                    ->required()
                    ->numeric()
                    ->default(1),
                Toggle::make('is_active')
                    ->required(),
            ]);
    }
}
