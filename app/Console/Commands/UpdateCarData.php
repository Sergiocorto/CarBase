<?php

namespace App\Console\Commands;

use App\Http\Services\CarDataUpdater;
use Illuminate\Console\Command;

class UpdateCarData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-car-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update car data from external resource';

    /**
     * Execute the console command.
     */

    public function handle()
    {
        $carDataUpdater = new CarDataUpdater();
        $carDataUpdater->updateCarData();

        $this->info('Car data updated successfully!');
    }
}
