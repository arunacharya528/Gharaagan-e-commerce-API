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
        $this->subject($subject);
        $this->body = $body;
        $this->priority($priorityLevel);
    }

    public function setAttachment($attachment, $name, $options)
    {
        $this->attachData($attachment, $name, $options);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('vendor.mail.html.message', ['slot' => $this->body]);
    }
}
