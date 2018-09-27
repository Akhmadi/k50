<?php

namespace App\Jobs;

use App\Mail\EventUserRegistered;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class EventUserRegisterMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    protected $eventUser;
    protected $eventName;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($eventUser, $eventName)
    {
        $this->eventUser = $eventUser;
        $this->eventName = $eventName;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        Mail::to(crud_settings('site.sobytiya_registration_email'))->send( new EventUserRegistered($this->eventUser, $this->eventName));

    }
}
