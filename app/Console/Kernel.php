<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Excel;
use App\Mail\EventUsersList;

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
          
        
        $schedule->call(function(){
           
            $posts = \App\Post::where('post_type_id','7')->get();

            foreach ($posts as $post){
                $regStatus = $post->getMetaValue('event.registration');

                if ($regStatus == 'ENABLED'){
                    $eventDate = new Carbon($post->getMetaValue('event.date'));
                    $dayBefore = $post->getMetaValue('event.days_before_start');
                    $maxUsers = $post->getMetaValue('event.max_memebrs_count');
                    $users = $post->registeredUsers()->get();

                    if ((Carbon::now()->gte($eventDate->subDays($dayBefore))) || ($users->count() >= ($maxUsers))){
                        $collection = collect([]);
                        $fileName = str_replace(":","_",$post->title) . '.xlsx';                        

                        foreach($users as $user){
                            $packet = json_decode($user->pivot->meta);
                            $collection->push([$post->title,$user->last_name,$user->first_name, $user->phone, $user->email, 
                                $user->company, $user->position, $packet->title]);            
                        }

                        Excel::store(new \App\Exports\EventUserExport($collection), $fileName , 'excel'); //, \Maatwebsite\Excel\Excel::CSV
                        Mail::to(crud_settings('site.sobytiya_registration_email'))
                            ->send( new EventUsersList($post->title, $fileName));

                        $post['meta->event->registration'] = 'DISABLED';
                        $post->save();
                      }
                }
            }

        })->twiceDaily(8, 16);;

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
