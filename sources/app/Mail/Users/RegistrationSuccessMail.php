<?php

namespace App\Mail\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\Mime\Address;

class RegistrationSuccessMail extends Mailable
{
    use Queueable, SerializesModels;

    readonly string $email;
    readonly string $login;
    readonly string $password;

    /**
     * Create a new message instance.
     */
    public function __construct(string $email, string $login, string $password)
    {
        $this->email = $email;
        $this->login = $login;
        $this->password = $password;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address('VuacheslavMironov@yandex.ru', 'SportExperts'),
            to: $this->email,
            subject: 'Регистрация в SportExperts',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'email.users.registration',
            with: [
                'link' => 'http:sport-experts.ru',
                'login' => $this->login,
                'password' => $this->password,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
