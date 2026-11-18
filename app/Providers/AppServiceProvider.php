<?php

namespace App\Providers;

use App\Models\LogAktivitas;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Setiap login berhasil dicatat
        Event::listen(Login::class, function ($event) {
            LogAktivitas::catat('Login', $event->user->id_user);
        });

        // Setiap logout dicatat
        Event::listen(Logout::class, function ($event) {
            if ($event->user) {
                LogAktivitas::catat('Logout', $event->user->id_user);
            }
        });
    }
}