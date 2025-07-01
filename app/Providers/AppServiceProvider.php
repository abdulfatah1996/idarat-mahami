<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;

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
        // use bootstrap 5 pagination
        Carbon::setLocale(config('app.locale'));


        // Share the authenticated user with all views
        View::composer('*', function ($view) {
            $view->with('user', Auth::check() ? Auth::user() : null);
        });
    }
}
