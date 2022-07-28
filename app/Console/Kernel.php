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
        // $schedule->command('ib:status')->everyMinute();
        // $schedule->command('ib:getcandle 1min')->everyTwoMinutes();
        // $schedule->command('ib:getcandle 2min')->everyTwoMinutes();
        // $schedule->command('ib:getcandle 3min')->everyThreeMinutes();
        // $schedule->command('ib:getcandle 5min')->everyFiveMinutes();
        // $schedule->command('ib:getcandle 10min')->everyTenMinutes();
        // $schedule->command('ib:getcandle 15min')->everyFifteenMinutes();
        // $schedule->command('ib:getcandle 30min')->everyThirtyMinutes();
        // $schedule->command('ib:getcandle 1h')->hourly();

        //stk RTH

        //1min
        $schedule->command('ib:getprice STK 1min')->cron('31-59 13 * * 1,2,3,4,5');//from 13:31 to 13:59
        $schedule->command('ib:getprice STK 1min')->cron('* 14-19 * * 1,2,3,4,5');//from 14 to 19:59
        //last candle

        //5min
        $schedule->command('ib:getprice STK 5min')->cron('35-59/5 13 * * 1,2,3,4,5');//from 13:35 to 13:55
        $schedule->command('ib:getprice STK 5min')->cron('*/5 14-19 * * 1,2,3,4,5');//from 14 to 19:55
        //last candle

        //10min
        $schedule->command('ib:getprice STK 10min')->cron('40-59/10 13 * * 1,2,3,4,5');//from 13:40 to 13:50
        $schedule->command('ib:getprice STK 10min')->cron('*/10 14-19 * * 1,2,3,4,5');//from 14 to 19:50
        //last candle

        //15min
        $schedule->command('ib:getprice STK 15min')->cron('45 13 * * 1,2,3,4,5');//from 13:45 to 13:45
        $schedule->command('ib:getprice STK 15min')->cron('*/15 14-19 * * 1,2,3,4,5');//from 14 to 19:45
        //last candle

        //30min
        // $schedule->cron('30-59/15 13 * * 1,2,3,4,5');//from 13:30 to 14
        $schedule->command('ib:getprice STK 30min')->cron('*/30 14-19 * * 1,2,3,4,5');//from 14 to 19:30
        //last candle

        //1h
        $schedule->command('ib:getprice STK 1h')->cron('30 14-19 * * 1,2,3,4,5');//from 14:30 to 19:30
        //last candle

        //2h
        $schedule->command('ib:getprice STK 2h')->cron('30 15-19/2 * * 1,2,3,4,5');//from 15:30 to 19:30
        //last candle

        //4h
        $schedule->command('ib:getprice STK 4h')->cron('30 18 * * 1,2,3,4,5');//at 18:30
        $schedule->command('ib:getprice STK 4h')->cron('00 20 * * 1,2,3,4,5');//at 20:00 //last candle

        //1d
        $schedule->command('ib:getprice STK 1d')->cron('00 20 * * 1,2,3,4,5');//at 20:00 //last candle



        //fut ETH

        //1min
        $schedule->command('ib:getprice FUT 1min')->cron('1-59 22 * * 1,2,3,4,5');//from 22:01 to 22:59
        $schedule->command('ib:getprice FUT 1min')->cron('* 23 * * 1,2,3,4,5');//from 23:00 to 23:59
        $schedule->command('ib:getprice FUT 1min')->cron('* 0-20 * * 1,2,3,4,5');//from 00:00 to 20:59
        //last candle

        //5min
        $schedule->command('ib:getprice FUT 5min')->cron('5-59/5 22 * * 1,2,3,4,5');//from 22:05 to 22:55
        $schedule->command('ib:getprice FUT 5min')->cron('*/5 23 * * 1,2,3,4,5');//from 23:00 to 23:55
        $schedule->command('ib:getprice FUT 5min')->cron('*/5 0-20 * * 1,2,3,4,5');//from 00:00 to 20:55
        //last candle

        //10min
        $schedule->command('ib:getprice FUT 10min')->cron('10-59/10 22 * * 1,2,3,4,5');//from 22:10 to 22:50
        $schedule->command('ib:getprice FUT 10min')->cron('*/10 23 * * 1,2,3,4,5');//from 23:00 to 23:50
        $schedule->command('ib:getprice FUT 10min')->cron('*/10 0-20 * * 1,2,3,4,5');//from 00:00 to 20:50
        //last candle

        //15min
        $schedule->command('ib:getprice FUT 15min')->cron('15-45/15 22 * * 1,2,3,4,5');//from 22:15 to 22:45
        $schedule->command('ib:getprice FUT 15min')->cron('*/15 23 * * 1,2,3,4,5');//from 22:15 to 22:45
        $schedule->command('ib:getprice FUT 15min')->cron('*/15 0-20 * * 1,2,3,4,5');//from 22:15 to 20:45
        //last candle

        //30min
        $schedule->command('ib:getprice FUT 30min')->cron('30 22 * * 1,2,3,4,5');//at 22:30
        $schedule->command('ib:getprice FUT 30min')->cron('*/30 23 * * 1,2,3,4,5');//from 23:00 to 23:30
        $schedule->command('ib:getprice FUT 30min')->cron('*/30 0-20 * * 1,2,3,4,5');//from 00:00 to 20:30
        //last candle

        //1h
        $schedule->command('ib:getprice FUT 1h')->cron('0 23 * * 1,2,3,4,5');//at 23:00
        $schedule->command('ib:getprice FUT 1h')->cron('0 00-20 * * 1,2,3,4,5');//from 00:00 to 20:00
        //last candle

        //2h
        $schedule->command('ib:getprice FUT 2h')->cron('0 0-20/2 * * 1,2,3,4,5');//from 00:00 to 20:00
        //last candle

        //4h
        $schedule->command('ib:getprice FUT 4h')->cron('0 2-20/4 * * 1,2,3,4,5');//from 00:00 to 20:00
        //last candle

        //1d
        $schedule->command('ib:getprice FUT 1d')->cron('00 21 * * 1,2,3,4,5');//at 21:00


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
