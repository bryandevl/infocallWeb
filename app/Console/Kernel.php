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
        Commands\Serch\SerchSource::class,
        Commands\Serch\PeopleInfo::class,
        Commands\Serch\PeopleSbs::class,
        Commands\Serch\PeopleEssalud::class,
        Commands\Serch\PeopleTelefonos::class,
        Commands\Serch\PeopleCorreo::class,
        Commands\Serch\PeopleFamiliares::class,

        Commands\Test\PeopleSbsDetailTmp::class,
        
        Commands\EssaludSource::class,
        Commands\ReniecSource::class,
        Commands\AsignacionSource::class,
        Commands\CorreoSource::class,
        
        Commands\Operador\TranslateTextNotification::class,
        Commands\Operador\UploadPhoneCommand::class,
        
        Commands\Validata\ValidataSource::class,
        Commands\Validata\ValidataCruceSbsDetail::class,

        Commands\Supervisor\UploadCorreoCommand::class,
    ];

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
