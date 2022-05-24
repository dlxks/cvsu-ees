<?php

namespace App\Console;

use App\Console\Commands\ScheduleActive;
use App\Console\Commands\ScheduleEnded;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        ScheduleActive::class,
        ScheduleEnded::class,
    ];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('quote:daily');

        $schedule->command('schedule:active')
            ->dailyAt('07:00');

        $schedule->command('schedule:ended')
            ->dailyAt('19:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
