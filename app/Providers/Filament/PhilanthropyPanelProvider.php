<?php

namespace App\Providers\Filament;

use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Althinect\FilamentSpatieRolesPermissions\FilamentSpatieRolesPermissionsPlugin;
use Filament\Navigation\MenuItem;

class PhilanthropyPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->sidebarCollapsibleOnDesktop(true)
            ->id('philanthropy')
            ->path('philanthropy')
            ->login()->colors([
                'primary' => Color::Amber,
                'danger'  => Color::hex('#7B1B1C'),   // Merah Gelap (untuk error/hapus)
                'warning' => Color::hex('#7C170D'),   // Sesuaikan kode hex ini (untuk peringatan)
                'info'    => Color::hex('#141A45'),   // Biru Navy (untuk informasi)
                'success' => Color::hex('#D3BAA6'),   // Krem (bisa disesuaikan)
                'gray'    => Color::hex('#7C170D'),   // Krem terang (bisa untuk warna dasar abu-abu)
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                // FilamentInfoWidget::class,
            ])
            ->navigationGroups([
                'User Management',
                'Grant',
                'Course',
                'Audit',
                'Progess',
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ])
            ->plugin(FilamentSpatieRolesPermissionsPlugin::make());
            // ->viteTheme('resources/css/filament/philanthropy/theme.css');
    }

    public function boot(): void
    {
        Filament::serving(function () {
            Filament::registerUserMenuItems([
                MenuItem::make()
                    ->label('Settings')
                    ->icon('heroicon-o-cog'),
                MenuItem::make()
                    ->label('Logout')
                    ->icon('heroicon-o-arrow-left-on-rectangle'),
            ]);
        });
    }
}