<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \App\Console\Commands\GenerateSitemap::class,
    ];

    protected function schedule(Schedule $schedule): void
    {
        // 可以在这里添加计划任务
    }
}
