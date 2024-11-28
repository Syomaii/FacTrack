<?php

namespace App\Providers;

use App\Events\ReserveEquipmentEvent;
use App\Listeners\SendReservationListener;
use App\Models\Reservation;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ReserveEquipmentEvent::class => [
            SendReservationListener::class,
        ]
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        
    }
}
