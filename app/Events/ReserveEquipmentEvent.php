<?php

namespace App\Events;

use App\Models\EquipmentReservation;
use App\Models\Reservation;
use App\Models\Students;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReserveEquipmentEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public $reservation;
    public $student;
    public $office;
    public $equipment;

    public function __construct(EquipmentReservation $reservation, $student, $office, $equipment)
    {
        $this->reservation = $reservation;
        $this->student = $student;
        $this->office = $office;
        $this->equipment = $equipment;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
