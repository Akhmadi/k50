<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserRegistered extends Mailable
{
    use Queueable;


    public $user;

    /**
     *
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        if (isset($this->user['files']) && count($this->user['files']))
            foreach ($this->user['files'] as $file)
                $this->attach('storage/app/public/'.$file);

        return $this->view('emails.students.registered');
    }
}
