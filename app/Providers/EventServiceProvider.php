<?php

namespace App\Providers;

use App\Events\OverdueEquipmentEvent;
use App\Events\ReserveEquipmentEvent;
use App\Listeners\OverdueEquipmentListener;
use App\Listeners\SendReservationListener;
use App\Models\Reservation;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        ReserveEquipmentEvent::class => [
            SendReservationListener::class,
        ],
        OverdueEquipmentEvent::class => [
            OverdueEquipmentListener::class,
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
