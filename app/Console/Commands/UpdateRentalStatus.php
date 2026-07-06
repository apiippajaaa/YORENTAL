<?php

namespace App\Console\Commands;

use App\Models\CarRental;
use Carbon\Carbon;
use Illuminate\Console\Command;

class UpdateRentalStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-rental-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();

        // Ubah status dari 'booked' ke 'sedang_digunakan' jika waktunya tiba
        CarRental::where('status', 'booked')
            ->where('start_time', '<=', $now)
            ->update(['status' => 'on_rent']);
    }
}
