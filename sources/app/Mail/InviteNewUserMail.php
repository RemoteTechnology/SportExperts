<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteNewUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $personalUrl;
    /**
     * Create a new message instance.
     */
    public function __construct(string $personalUrl)
    {
        $this->personalUrl = $personalUrl;
    }

    public function build(): InviteNewUserMail
    {
        return $this->subject('Приглашение на событие!')
            ->view('email.invite.index', ['personalUrl' => $this->personalUrl]);
    }
}
