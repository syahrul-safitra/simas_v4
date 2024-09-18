<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

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
        // ini digunakan untuk ngrok : 
        // if (config('app.env') === 'local') {
        //     URL::forceScheme('https');
        // }

        // GATE : user non kasubag : 
        Gate::define('non_kasubag', function (User $user) {
            return $user->permission == '1';
        });

        // GATE : untuk kasubag : 
        Gate::define('kasubag', function (User $user) {
            return $user->permission == '0';
        });

        // Gate : untuk staff : 
        Gate::define('staff', function (User $user) {
            return $user->level == 'master';
        });
    }
}
