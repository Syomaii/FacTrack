<?php

namespace App\Console\Commands;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;

class MarkInactiveUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:mark-inactive';

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
        $thresholdDate = Carbon::now()->subSeconds(30); //change to 30 if done with testing
        
        $users = User::where('last_login_at', '<', $thresholdDate)
                     ->where('status', '!=', 'inactive')
                     ->get();

        foreach ($users as $user) {
            $user->status = 'inactive'; 
            $user->save();
            $this->info('User ' . $user->firstname . ' has been marked as inactive.');
        }

        $this->info('User status update complete.');
    }
}
