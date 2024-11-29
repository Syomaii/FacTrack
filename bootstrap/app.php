<?php

use App\Events\OverdueEquipmentEvent;
use Illuminate\Foundation\Application;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Models\Borrower;
use App\Models\Student; // Assuming you have a Student model
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'checkRole' => \App\Http\Middleware\CheckUserRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->booted(function () {
        $schedule = app(Schedule::class);

        // Schedule your custom event
        $schedule->call(function () {
            // Fetch overdue borrowers
            $overdueBorrowers = Borrower::whereNull('returned_date')
                ->where('expected_returned_date', '<', Carbon::now())
                ->get();

            foreach ($overdueBorrowers as $borrower) {
                $student = $borrower->student;      
                $equipment = $borrower->equipment;  

                // Dispatch the OverdueEquipmentEvent for each overdue borrower
                try {
                    Log::info($borrower);
                    
                    event(new OverdueEquipmentEvent($borrower, $student, $equipment));
                    
                } catch (\Exception $e) {
                    Log::error('errors: '. $borrower . $student . $equipment);
                    Log::error('Scheduled Task Failed: ' . $e->getMessage());
                }
            }
        })->everyTenSeconds(); // Adjust frequency as needed
    })
    ->create();
