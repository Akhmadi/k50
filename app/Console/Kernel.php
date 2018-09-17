<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

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
        $schedule->call(function(){
            cache()->forever('cached.phrases', getRandomPhrases(5) );

            cache()->forever('cached.featuredEvents', getFeatureEvents() );

            cache()->forever('cached.pastEvents', getPastEvents() );

            cache()->forever('cached.ratings', \App\Post::ratings()->onlyEnabled()->take(3)->orderBy('id', 'desc')->get() );

            cache()->forever('cached.news',
                 \App\Post::news()
                    ->select(['title', 'image','slug','excerpt','created_at','post_type_id', 'views'])
                    ->onlyEnabled()
                     ->with(['postType.page'])

                    ->orderBy('id', 'desc')
                    ->take(4)
                    ->get());

            cache()->forever('cached.slides',
                \App\Post::slides()->onlyEnabled()->orderBy('created_at', 'desc')->get());
        })->everyMinute();

	    $schedule->call(function(){

	    	$serializedJobs = DB::table('jobs')->select()->get();

	    	foreach ($serializedJobs as $serializedJob){

	    		$jsonJob = json_decode($serializedJob->payload);

			    $job = unserialize( $jsonJob->data->command);

			    $job->handle();

			    DB::table('jobs')->where('id', '=', $serializedJob->id)->delete();
		    }

	    })->everyMinute()
		  ->name('jobs_dispatch')
	      ->withoutOverlapping();

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
