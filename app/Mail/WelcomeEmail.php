<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WelcomeEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $petOwner;

    /**
     * Create a new message instance.
     */
    public function __construct($petOwner)
    {
        $this->petOwner = $petOwner;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Welcome to Happy Tails!')
            ->view('emails.welcome_email');
    }
}
