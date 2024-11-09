<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MarkInactiveUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:mark-inactive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marks users as inactive if they haven\'t logged in for 30 days';
    /**
     * Execute the console command.
     */
    public function handle()
    {
        $thresholdDate = Carbon::now()->subDays(30);
        
        User::where('last_login_at', '<', $thresholdDate)
            ->where('status', 'active')
            ->update(['status' => 'inactive']);

        $this->info('Inactive users marked successfully.');
    }
}
