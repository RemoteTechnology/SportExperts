<?php

namespace App\Mail\Participants;

use App\Mail\Users\CreateUserMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CreateParticipantMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $eventName;
    public string $firstName;
    public string $lastName;
    /**
     * Create a new message instance.
     */
    public function __construct(string $eventName, string $firstName, string $lastName)
    {
        $this->eventName = $eventName;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }

    public function build(): CreateParticipantMail
    {
        return $this->subject('Добавление спортсмена на событие SportExperts.')
            ->view('email.participants.create', [
                'eventName' => $this->eventName,
                'firstName' => $this->firstName,
                'LastName' => $this->lastName,
            ]);
    }
}
