<?php

namespace App\Console;

use App\Console\Commands\CancelPastAppointments;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        CancelPastAppointments::class,
    ];

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('appointments:cancel-past')->everyMinute();
    }
}
