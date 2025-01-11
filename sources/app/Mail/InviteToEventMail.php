<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteToEventMail extends Mailable
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

    public function build(): InviteToEventMail
    {
        return $this->subject('Приглашение на событие!')
            ->view('email.invite.index', [
                'attributes' => $this->attributes,
                'host' => "https://sportexperts.su", //TODO: Вернуться к проблеме
            ]);
    }
}
