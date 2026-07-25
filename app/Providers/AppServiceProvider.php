<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (Session::has('success')) {
            Notification::make()
                ->title('Berhasil!')
                ->body(Session::get('success'))
                ->success()
                ->send();
        }
    }
}
