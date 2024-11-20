<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ReserveEquipmentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'equipment:reserve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users that a student have reserved an equipment in their department';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        
    }
}
