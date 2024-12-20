<?php

namespace App\Mail\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $attributes;
    /**
     * Create a new message instance.
     */
    public function __construct(array $attributes)
    {
        $this->attributes = $attributes;
    }

    public function build(): RegistrationUserMail
    {
        return $this->subject('Регистрация на платформе SportExperts.')
            ->view('email.users.registration', $this->attributes);
    }
}
