<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\DailyRunforpaymenttypeCron::class,
        Commands\offer_payment::class,
        Commands\Group_discount::class,
        Commands\normal_payment::class,    
       
    ];
    protected function schedule(Schedule $schedule)
    {
   
        $schedule->command('DailyRunforpaymenttypeCron:cron')->everyMinute();
        $schedule->command('offer_payment:cron')->everyMinute();
        $schedule->command('Group_discount:cron')->everyMinute();
        $schedule->command('normal_payment:name')->everyMinute();
      
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
