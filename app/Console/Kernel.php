<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\CarReview::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        #$schedule->command('command:carReview')->everyFourHours();

        $schedule->command('queue:work --once --sleep=3 --tries=3 --timeout=90')
            ->everyMinute()
            ->withoutOverlapping();

        $schedule->command('command:notifyLembrete')
            ->everyMinute()
            ->withoutOverlapping();

        $schedule->command('telescope:prune --hours=48')->daily();

        #$schedule->command('app:programacao-status-apr-vencida')->everyMinute();

        $schedule->command('backup:clean --disable-notifications')
            ->daily()
            ->at('01:00')
            ->onFailure(fn() => slack(['Erro ao limpar o backup']));

        $schedule->command('backup:run --disable-notifications')
            ->daily()
            ->at('01:30')
            ->onFailure(fn() => slack(['Erro ao fazer o backup']));
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
