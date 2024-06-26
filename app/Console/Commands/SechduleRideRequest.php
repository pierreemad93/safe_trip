<?php

namespace App\Console\Commands;

use App\Models\RideRequest;
use Illuminate\Console\Command;

class SechduleRideRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rideRequestSchedule:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'to check ride request schedule';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $rideRequest = RideRequest::where('is_schedule', 1)->get();
    }
}
