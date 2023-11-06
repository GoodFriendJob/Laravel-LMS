<?php

namespace App\Console;

use App\Console\Commands\Backup;
use App\Console\Commands\GenerateSitemap;
use App\Console\Commands\LessonTestChaterStudentsFix;
use App\Console\Commands\TeacherProfileFix;
use App\Models\TeacherProfile;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

/**
 * Class Kernel.
 */
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Backup::class,
        GenerateSitemap::class,
        TeacherProfileFix::class,
        LessonTestChaterStudentsFix::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

        if (config('backup_schedule') == 1) {
            $schedule->command(Backup::class)->daily();
        } elseif (config('backup_schedule') == 2) {
            $schedule->command(Backup::class)->weekly();

        } elseif (config('backup_schedule') == 3) {
            $schedule->command(Backup::class)->monthly();
        }


        if (config('sitemap.schedule') == 1) {

            $schedule->command(GenerateSitemap::class)->daily();

        } elseif (config('sitemap.schedule') == 2) {

            $schedule->command(GenerateSitemap::class)->weekly();

        } elseif (config('sitemap.schedule') == 3) {

            $schedule->command(GenerateSitemap::class)->monthly();

        }
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
