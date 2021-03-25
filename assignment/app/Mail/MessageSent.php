<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageSent extends Mailable
{
    use Queueable, SerializesModels;

    public $messageUrl;

    /**
     * Create a new message instance.
     *
     * @param string $messageUrl
     */
    public function __construct(string $messageUrl)
    {
        $this->messageUrl = $messageUrl;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.messageurl');
    }
}
