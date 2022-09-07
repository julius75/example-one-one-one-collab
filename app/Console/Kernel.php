<?php

namespace Dervis\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        parent::schedule($schedule);
//        $schedule->command('collabmed:auto-sync')->everyTenMinutes();
        $schedule->command(
            "db:backup --database=mysql --destination=". env("BACKUP_POINT_TYPE") .' --destinationPath='. env("DB_DATABASE") .' --timestamp="Y_m_d_H_i_s" --compression=gzip'
         )->dailyAt("03:00");
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
