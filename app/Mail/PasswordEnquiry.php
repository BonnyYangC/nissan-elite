<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordEnquiry extends Mailable
{
    use Queueable, SerializesModels;

    public $clientName;
    public $clientEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $clientEmail, string $name)
    {
        $this->clientName = $name;
        $this->clientEmail = $clientEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->clientEmail, $this->clientName)
            ->subject('Please reset password! (DO NOT REPLY)')
            ->view('emails.user.password_enquiry');
    }
}
