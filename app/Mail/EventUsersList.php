<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Contracts\Queue\ShouldQueue;

class EventUsersList extends Mailable
{
    use Queueable;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $eventName;
    public $fileName;

    public function __construct($eventName, $fileName)
    {
        $this->eventName = $eventName;
        $this->fileName = $fileName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.events.userslist')
                    ->subject('Список зарегистрированных на форуме')
                    ->attach('storage/app/public/uploads/ExcelReports/'.$this->fileName);
    }
}
