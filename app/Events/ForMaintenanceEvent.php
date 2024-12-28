<?php

namespace App\Events;

use App\Models\Equipment;
use App\Models\Repair;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ForMaintenanceEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

   
    public $repairs;
    public $equipment;
    public function __construct(Equipment $repairs, $equipment)
    {
        $this->repairs = $repairs;
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
