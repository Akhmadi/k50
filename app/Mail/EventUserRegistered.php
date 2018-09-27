<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EventUserRegistered extends Mailable
{
    use Queueable;


    public $eventUser;
    public $eventName;

    /**
     *
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($eventUser, $eventName)
    {
        $this->eventUser = $eventUser;
        $this->eventName = $eventName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.events.registered')->subject('Заявка на участие в форуме');
    }
}
