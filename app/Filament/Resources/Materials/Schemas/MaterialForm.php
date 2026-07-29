<?php

namespace App\Filament\Resources\Materials\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class MaterialForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->schema([
                // Membagi layar menjadi 1 kolom di HP, dan 2 kolom di layar desktop (md ke atas)
                Grid::make(['default' => 1, 'md' => 3]) 
                    ->schema([
                        
                        // ==========================================
                        // KOLOM KIRI (Mengambil 1 porsi layar)
                        // ==========================================
                        Group::make()
                            ->columnSpan(['default' => 1, 'md' => 2]) 
                            ->schema([
                                // 1. INFORMASI DASAR
                                Section::make('Informasi Dasar')
                                    ->description('Pilih sesi kursus dan tetapkan judul materi untuk modul yang ingin ditambahkan.')
                                    ->icon('heroicon-o-information-circle')
                                    ->columns(2)
                                    ->schema([
                                        Select::make('course_session_id')
                                            ->label('Course Session')
                                            ->relationship(name: 'courseSession', titleAttribute: 'title')
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->columnSpan(1),

                                        TextInput::make('title')
                                            ->label('Judul Materi')
                                            ->required()
                                            ->maxLength(255)
                                            ->columnSpan(1),
                                    ]),

                                // 2. PENGATURAN KONTEN
                                Section::make('Pengaturan Konten')
                                    ->description('Atur tipe konten, urutan tampil, dan status wajib materi.')
                                    ->icon('heroicon-o-adjustments-horizontal')
                                    ->schema([
                                        Select::make('content_type')
                                            ->label('Tipe Konten')
                                            ->options([
                                                'VIDEO' => 'Video',
                                                'PDF' => 'PDF',
                                                'TEXT' => 'Text',
                                                'AUDIO' => 'Audio',
                                            ])
                                            ->required()
                                            ->live()
                                            ->native(false),

                                        TextInput::make('order')
                                            ->label('Urutan Tampil')
                                            ->required()
                                            ->numeric()
                                            ->minValue(1)
                                            ->default(1),

                                        Toggle::make('is_required')
                                            ->label('Wajib Dipelajari')
                                            ->default(true)
                                            ->required()
                                            ->inline(false),
                                    ]),
                            ]),

                        // ==========================================
                        // KOLOM KANAN (Mengambil 1 porsi layar)
                        // ==========================================
                        Group::make()
                            ->columnSpan(['default' => 1, 'md' => 1])
                            ->schema([
                                
                                // 3. DETAIL KONTEN
                                Section::make('Detail Konten')
                                    ->description('Isi sumber konten atau deskripsi sesuai tipe materi yang dipilih.')
                                    ->icon('heroicon-o-document-text')
                                    ->collapsible()
                                    ->schema([
                                        TextInput::make('content_url')
                                            ->label('Content URL')
                                            ->url()
                                            ->placeholder('https://example.com/video.mp4')
                                            ->helperText('Wajib diisi untuk tipe Video, PDF, dan Audio.')
                                            // Catatan: Type-hint 'Get' dihapus agar tidak error lintas namespace
                                            ->visible(fn($get) => in_array($get('content_type'), ['VIDEO', 'PDF', 'AUDIO'], true))
                                            ->required(fn($get) => in_array($get('content_type'), ['VIDEO', 'PDF', 'AUDIO'], true)),

                                        RichEditor::make('body_text')
                                            ->label('Body Text / Description')
                                            ->toolbarButtons([
                                                'bold', 'italic', 'underline', 'strike',
                                                'bulletList', 'orderedList', 'link', 'h2', 'h3',
                                            ])
                                            ->placeholder('Tulis deskripsi atau isi materi untuk jenis konten text.')
                                            ->helperText('Hanya wajib saat tipe konten adalah Text.')
                                            ->visible(fn($get) => $get('content_type') === 'TEXT')
                                            ->required(fn($get) => $get('content_type') === 'TEXT'),
                                    ]),

                                // 4. ASSIGNMENT
                                Section::make('Assignment')
                                    ->description('Aktifkan jika materi ini juga memiliki tugas yang harus diselesaikan peserta.')
                                    ->icon('heroicon-o-clipboard-document-check')
                                    ->collapsible()
                                    ->schema([
                                        Toggle::make('has_assignment')
                                            ->label('Aktifkan Assignment')
                                            ->default(false)
                                            ->live()
                                            ->inline(false)
                                            ->columnSpanFull(),

                                        TextInput::make('assignment_title')
                                            ->label('Judul Tugas')
                                            ->maxLength(255)
                                            ->visible(fn($get) => (bool) $get('has_assignment'))
                                            ->required(fn($get) => (bool) $get('has_assignment'))
                                            ->columnSpan(1),

                                        TextInput::make('max_score')
                                            ->label('Skor Maksimal')
                                            ->numeric()
                                            ->default(100)
                                            ->minValue(1)
                                            ->visible(fn($get) => (bool) $get('has_assignment'))
                                            ->required(fn($get) => (bool) $get('has_assignment'))
                                            ->columnSpan(1),

                                        DateTimePicker::make('due_date')
                                            ->label('Batas Waktu')
                                            ->native(false)
                                            ->visible(fn($get) => (bool) $get('has_assignment'))
                                            ->columnSpan(1),

                                        Toggle::make('allow_offline_submission')
                                            ->label('Boleh Submit Offline')
                                            ->default(true)
                                            ->inline(false)
                                            ->visible(fn($get) => (bool) $get('has_assignment'))
                                            ->columnSpan(1),

                                        Textarea::make('assignment_description')
                                            ->label('Instruksi Tugas')
                                            ->rows(3)
                                            ->visible(fn($get) => (bool) $get('has_assignment'))
                                            ->columnSpanFull(),
                                    ]),
                            ]),
                    ]),
            ]);
    }
}