<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class DecryptCodeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $decryptKey;

    /**
     * Create a new message instance.
     *
     * @param string $decryptKey
     */
    public function __construct(string $decryptKey)
    {
        $this->decryptKey = $decryptKey;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mail.decryptcode');
    }
}
