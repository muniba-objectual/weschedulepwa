<?php

namespace App\Console;

use App\Http\Controllers\Qb\QbResourceController;
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
        \App\Console\Commands\SyncQbVendors::class,
        \App\Console\Commands\SyncQbItemCategories::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /**
         * Setup Cronjob!
         * "* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1"
        */

        // $schedule->command('inspire')->hourly();
	    $schedule->command('media-library:delete-old-temporary-uploads')->daily();

        $schedule->command('sync:qb-vendors')->everyTenMinutes();
        $schedule->command('sync:qb-item-categories')->everyTenMinutes();

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
