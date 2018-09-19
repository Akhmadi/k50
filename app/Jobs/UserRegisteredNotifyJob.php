<?php

namespace App\Jobs;

use App\Mail\HelloUser;
use App\Mail\UserRegistered;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;

class UserRegisteredNotifyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;


    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {

        Mail::to($this->user->email)->send( new HelloUser($this->user));

        Mail::to(env('MAIL_USER_NOTIFY_TO'))->send( new UserRegistered($this->user));

    }
}
