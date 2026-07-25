<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum MaterialType: string implements HasLabel, HasColor, HasIcon
{
    case Video = 'video';
    case Pdf = 'pdf';
    case Text = 'text';
    case Quiz = 'quiz';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Video => 'Video Pembelajaran',
            self::Pdf => 'Dokumen PDF',
            self::Text => 'Artikel / Teks',
            self::Quiz => 'Kuis / Evaluasi',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Video => 'danger',
            self::Pdf => 'warning',
            self::Text => 'info',
            self::Quiz => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Video => 'heroicon-m-play-circle',
            self::Pdf => 'heroicon-m-document-text',
            self::Text => 'heroicon-m-bars-3-bottom-left',
            self::Quiz => 'heroicon-m-question-mark-circle',
        };
    }
}