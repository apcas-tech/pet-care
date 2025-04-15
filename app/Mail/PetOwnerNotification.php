<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PetOwnerNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $ownerName;

    /**
     * Create a new message instance.
     */
    public function __construct($ownerName)
    {
        $this->ownerName = $ownerName;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Important Notification from Happy Tails')
            ->view('emails.pet_owner_notification');
    }
}
