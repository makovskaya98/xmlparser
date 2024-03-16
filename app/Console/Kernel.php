<?php

namespace App\Console;

use App\Jobs\xmlHandlerJob;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Feeds;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule): void
    {
        $schedule->call(function () {
            $feeds = Feeds::all();
            foreach ($feeds as $feed) {
                xmlHandlerJob::dispatch($feed);
            }
        })->hourly();
    }

    protected function commands(): void
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
