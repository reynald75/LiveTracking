<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\PilotInFlight;
use App\Models\Flight;
use DateInterval;
use DateTime;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function(){
            $dateTime = new DateTime();
            PilotInFlight::where('created_at', '<=', $dateTime->format("Y-m-d"))->delete();

            $dateTime->sub(new DateInterval("P7D")); //Sub 7 days from current date
            Flight::where('created_at', '<=', $dateTime->format("Y-m-d"))->delete();
        })->dailyAt('00:01');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
