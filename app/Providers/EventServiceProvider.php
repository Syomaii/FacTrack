<?php

namespace App\Providers;

use App\Events\AcceptEquipmentReservationEvent;
use App\Events\AcceptFacilityReservationEvent;
use App\Events\DeclineEquipmentReservationEvent;
use App\Events\DeclineFacilityReservationEvent;
use App\Events\FacilityReservationEvent;
use App\Events\ForMaintenanceEvent;
use App\Events\OverdueEquipmentEvent;
use App\Events\ReserveEquipmentEvent;
use App\Listeners\AcceptEquipmentReservationListener;
use App\Listeners\AcceptFacilityReservationListener;
use App\Listeners\DeclineEquipmentReservationListener;
use App\Listeners\DeclineFacilityReservationListener;
use App\Listeners\FacilityReservationListener;
use App\Listeners\ForMaintenanceListener;
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
        ],
        AcceptEquipmentReservationEvent::class => [
            AcceptEquipmentReservationListener::class,
        ],
        DeclineEquipmentReservationEvent::class => [    
            DeclineEquipmentReservationListener::class,
        ],
        FacilityReservationEvent::class => [
            FacilityReservationListener::class,
        ],
        AcceptFacilityReservationEvent::class => [
            AcceptFacilityReservationListener::class,
        ],
        DeclineFacilityReservationEvent::class => [
            DeclineFacilityReservationListener::class,
        ],
        ForMaintenanceEvent::class => [
            ForMaintenanceListener::class,
        ],
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
