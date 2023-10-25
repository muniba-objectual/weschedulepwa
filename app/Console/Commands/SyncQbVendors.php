<?php

namespace App\Console\Commands;

use App\Http\Controllers\Qb\QbVendorController;
use Illuminate\Console\Command;

class SyncQbVendors extends Command
{
    //php artisan sync:qb-vendors

    protected $signature = 'sync:qb-vendors';
    protected $description = 'Force sync QB vendors';

    public function handle()
    {
        $qbController = new QbVendorController();
        $response = $qbController->sync(command: $this);

        // Log the response or handle it as per your requirement
        $this->info('QB vendors synced successfully.');

    }
}
