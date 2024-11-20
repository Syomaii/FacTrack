<?php

namespace App\Console\Commands;

use App\Models\Equipment;
use App\Models\User;
use App\Notifications\MaintenanceDueNotification;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class CheckMaintenanceDueCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'maintenance:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and perform maintenance tasks';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $equipments = Equipment::where('next_due_date', '<=', now())->get();

        foreach ($equipments as $equipment) {
            $user = Auth::user()->id; // Assuming each equipment is assigned to a user

            $user->notify(new MaintenanceDueNotification($equipment));
        }
    }
}
