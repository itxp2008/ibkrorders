<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

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
        // $schedule->command('inspire')->hourly();
        $schedule->command('ib:status')->everyMinute();
        $schedule->command('ib:getcandle 1min')->everyTwoMinutes();
        $schedule->command('ib:getcandle 2min')->everyTwoMinutes();
        $schedule->command('ib:getcandle 3min')->everyThreeMinutes();
        $schedule->command('ib:getcandle 5min')->everyFiveMinutes();
        $schedule->command('ib:getcandle 10min')->everyTenMinutes();
        $schedule->command('ib:getcandle 15min')->everyFifteenMinutes();
        $schedule->command('ib:getcandle 30min')->everyThirtyMinutes();
        $schedule->command('ib:getcandle 1h')->hourly();

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

    protected function bootstrappers()
    {
        return array_merge(
            [\Bugsnag\BugsnagLaravel\OomBootstrapper::class],
            parent::bootstrappers(),
        );
    }
}
