<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class resetPassword extends Mailable
{
    use Queueable, SerializesModels;

    protected $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $resetPasswordUrl = url('/reset-password/' . $this->token);

        return $this->from('contact@soyerbot.fr','SoyerBot')
            ->subject('SoyerBot : Réinitialiser votre mot de passe')
            ->view('email.resetPassword')
            ->with('resetPasswordUrl', $resetPasswordUrl);
    }
}