<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Laravel\Lumen\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //
    }

    /**
     * 注册应用的 Artisan 命令.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands'); // 加载自定义命令目录
        require base_path('routes/console.php'); // 确保 console.php 路由文件存在
    }
}
