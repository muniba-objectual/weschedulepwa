<?php

namespace App\Console\Commands;

use App\Http\Controllers\Qb\QbItemCategoryController;
use Illuminate\Console\Command;

class SyncQbItemCategories extends Command
{
    //php artisan sync:qb-vendors

    protected $signature = 'sync:qb-item-categories';
    protected $description = 'Force sync QB item categories (accounts)';

    public function handle()
    {
        $qbController = new QbItemCategoryController();
        $response = $qbController->sync(command: $this);

        // Log the response or handle it as per your requirement
        $this->info('QB item categories synced successfully.');

    }
}
