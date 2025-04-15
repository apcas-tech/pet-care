<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Appointment;
use Carbon\Carbon;

class CancelPastAppointments extends Command
{
    protected $signature = 'appointments:cancel-past';
    protected $description = 'Cancel appointments that are in the past';

    public function handle()
    {
        $today = Carbon::today()->toDateString();

        $updated = Appointment::where('appt_date', '<', $today) // Change from yesterday to today
            ->whereIn('status', ['Pending', 'Scheduled'])
            ->update(['status' => 'Cancelled']);

        $this->info("Updated $updated past appointments to Cancelled.");
    }
}
