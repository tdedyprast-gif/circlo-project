<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum EnrollmentStatus: string implements HasLabel, HasColor
{
    case Active = 'active';
    case Completed = 'completed';
    case Dropped = 'dropped';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Active => 'Aktif Belajar',
            self::Completed => 'Lulus / Selesai',
            self::Dropped => 'Keluar / Batal',
        };
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Active => 'primary',
            self::Completed => 'success',
            self::Dropped => 'danger',
        };
    }
}