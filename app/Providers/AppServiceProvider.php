<?php

namespace App\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    
    public function boot()
    {
        // Share notifications with the navbar view
        View::composer('components.navbar', function ($view) {
            $notifications = Auth::check() ? Auth::user()->notifications()->whereNull('read_at')->get() : collect();
            $view->with('notifications', $notifications);
        });

        // Scheduling logic
        
    }
    

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
