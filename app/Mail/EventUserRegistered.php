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
    public $eventPackage;

    /**
     *
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($eventUser, $eventName, $eventPackage)
    {
        $this->eventUser = $eventUser;
        $this->eventName = $eventName;
        $this->eventPackage = $eventPackage;
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
