<?php

namespace Fleetbase\Mail;

use Fleetbase\Models\VerificationCode;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
// use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Queue\SerializesModels;

class VerifyEmail extends Mailable
{
    use Queueable;
    use SerializesModels;

    public string $verifyCode;
    public string $greeting;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($verifyCode, $subject = null, $user = null)
    {
        $this->verifyCode = $verifyCode instanceof VerificationCode ? $verifyCode->code : $verifyCode;
        $this->subject    = $subject ?? ($this->verifyCode . ' is your Fleetbase verification code');
        $this->greeting   = ($user && isset($user->name)) ? 'Hello, ' . $user->name . '!' : 'Hello!';
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject($this->subject)
            ->html((new MailMessage())
                    ->greeting($this->greeting)
                    ->line('Welcome to Fleetbase, use the code below to verify your email address and complete registration to Fleetbase.')
                    ->line('')
                    ->line('Your verification code: ' . $this->verifyCode)
                    ->render()
            );
    }
}
