<?php

namespace App\Filament\Widgets;

use App\Models\Grant;
use App\Models\Enrollment;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected ?string $pollingInterval = '10s';

    protected function getStats(): array
    {
        return [
            // 1. Total Grants Count
            Stat::make('Total Grants', Grant::count())
                ->description('Terdaftar')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            // 2. Akumulasi Total Pendanaan Hibah dari Kolom yang Benar
            Stat::make('Total Dana Hibah', 'Rp ' . number_format(Grant::sum('total_funding_amount'), 0, ',', '.'))
                ->description('Hibah')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('danger'),

            // 3. Total Enrollment berdasarkan Course aktif
            Stat::make('Peserta Aktif', Enrollment::whereIn('status', ['ENROLLED', 'IN_PROGRESS'])->count())
                ->description('Peserta')
                ->descriptionIcon('heroicon-m-user-plus')
                ->color('info'),
        ];
    }
}
