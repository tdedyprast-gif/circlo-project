<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum CourseStatus: string implements HasLabel, HasColor
{
    case Draft = 'draft';
    case Published = 'published';
    case Archived = 'archived';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Published => 'Telah Terbit',
            self::Archived => 'Diarsipkan',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Draft => 'warning',
            self::Published => 'success',
            self::Archived => 'gray',
        };
    }
}