<?php

namespace App\Console;

use App\Http\Controllers\CategoriesController;
use App\Models\Feeds;
use App\Modules\Parser;
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
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {

            $feeds = Feeds::all();

            foreach ($feeds as $feed) {
                $date = new \DateTime();
                $date->modify('-24 hours');
                $formatted_date = $date->format('Y-m-d H:i:s');

                if ($feed->schedule && $formatted_date > $feed->last_update) {
                    Parser::parse($feed->slug, 'false', 0, 0);
                    CategoriesController::countAllProductsInCategories();
                }
            }

        })->everyFiveMinutes();
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
