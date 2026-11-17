<?php

namespace App\Providers;

use App\Models\Appointment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        // Número de presupuestos que el cliente tiene por autorizar
        // (bolita roja en "Autorizaciones" del menú del cliente).
        View::composer('cliente.partials.menu', function ($view) {
            $view->with('pendingAuthorizations', self::pendingAuthorizationsCount());
        });
    }

    public static function pendingAuthorizationsCount(): int
    {
        $clientId = Auth::user()?->client?->id;

        if (!$clientId) {
            return 0;
        }

        return Appointment::where('client_id', $clientId)
            ->where('status', 'esperando_aprobacion')
            ->where('authorization_status', 'pendiente')
            ->count();
    }
}
