<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;


// 追加分
use App\Mail\Event\RemindEventStartForOrganizer;
use App\Mail\Event\RemindEventStartForParticipant;
use App\Mail\Event\QuestionnaireAfterEvent;
use Mail;
use App\Models\User;
use App\Models\Event;
use App\Models\EventParticipant;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        // 追加分
        $schedule->command('send:eventStartRemind')->everyTenMinutes();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}