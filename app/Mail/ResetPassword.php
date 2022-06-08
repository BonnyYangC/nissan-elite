<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

    public $clientName;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $name)
    {
        $this->clientName = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(config('elite.SUPPORT_EMAIL_ADDRESS'), config('elite.SUPPORT_EMAIL_NAME'))
            ->subject('Your password recovered! (DO NOT REPLY)')
            ->view('emails.user.reset_password');
    }
}
