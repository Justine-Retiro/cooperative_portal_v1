<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\App; 
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if (App::environment('prod')) {
            $this->app->bind('path.public', function() {
                return base_path('../../public_html');
            });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrapFive();
        \App\Models\Client::observe(\App\Observers\AuditLogObserver::class);
        \App\Models\Payment::observe(\App\Observers\AuditLogObserver::class);
    }
}
