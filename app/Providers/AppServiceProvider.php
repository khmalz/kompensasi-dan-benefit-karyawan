<?php

namespace App\Providers;

use App\Models\User;
use App\Models\Tunjangan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Gate::define('admin', function (User $user) {
            return $user->email === 'admin@gmail.com';
        });

        Gate::define('karyawan', function (User $user) {
            return $user->email !== 'admin@gmail.com';
        });

        view()->composer(
            'dashboard.layouts.sidebar',
            function ($view) {
                $view->with('total_tunjangan', Tunjangan::where('status', 'belum')->count());
            }
        );
    }
}
