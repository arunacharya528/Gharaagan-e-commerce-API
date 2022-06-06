<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Mailer extends Mailable
{
    use Queueable, SerializesModels;
    public $body, $subjectString, $priorityLevel;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $body, $priorityLevel = 3)
    {
        $this->body = $body;
        $this->subjectString = $subject;
        $this->priorityLevel = $priorityLevel;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject($this->subjectString)->priority($this->priorityLevel)->view('mail');
    }
}
