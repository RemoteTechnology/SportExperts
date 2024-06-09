<?php

namespace App\Mail\Users;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ResetMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $password;
    /**
     * Create a new message instance.
     */
    public function __construct(string $password)
    {
        $this->password = $password;
    }

    public function build(): ResetMail
    {
        return $this->subject('Восстановление пароля.')
            ->view('email.users.reset', ['password' => $this->password]);
    }
}
