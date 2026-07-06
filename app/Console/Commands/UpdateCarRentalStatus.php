<?php

namespace App\Console\Commands;

use App\Models\CarRental;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateCarRentalStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'car_rentals:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update status car rentals to on_rent if start_date sudah tiba dan status booked';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        $rentalsToUpdate = CarRental::where('status', 'booked')
            ->where('start_date', '<=', $now)
            ->get();

        foreach ($rentalsToUpdate as $rental) {
            $rental->update(['status' => 'on_rent']);
            $this->info("Rental ID {$rental->id} updated to on_rent.");
        }

        $this->info('Update completed.');
    }
}
