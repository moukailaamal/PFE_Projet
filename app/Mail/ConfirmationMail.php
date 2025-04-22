<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ConfirmationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $confirmationLink;

    /**
     * Create a new message instance.
     *
     * @param mixed $user
     * @param string $confirmationLink
     * @return void
     */
    public function __construct($user, $confirmationLink)
    {
        $this->user = $user;
        $this->confirmationLink = $confirmationLink;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email.confirmation')
                    ->subject('Confirmation Mail');
    }
}
