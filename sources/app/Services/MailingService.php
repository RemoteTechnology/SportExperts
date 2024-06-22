<?php

namespace App\Services;

use App\Mail\InviteNewUserMail;
use App\Mail\Users\CreateUserMail;
use App\Mail\Users\ResetMail;
use Illuminate\Mail\SentMessage;
use Illuminate\Support\Facades\Mail;

require_once dirname(__DIR__) . '/Domain/Constants/FieldConst.php';

class MailingService
{
    public function mailNewUser(array $attributes): SentMessage
    {
        return Mail::to($attributes[FIELD_EMAIL])->send(new CreateUserMail());
    }
    public function mailResetToPassword(array $attributes): SentMessage
    {
        return Mail::to($attributes[FIELD_EMAIL])->send(new ResetMail($attributes[FIELD_PASSWORD]));
    }
    public function mailInvite(array $attributes): SentMessage
    {

    }
    public function mailInvitedOrRecord(array $attributes): SentMessage
    {
        return Mail::to($attributes[FIELD_EMAIL])->send(new InviteNewUserMail($attributes['personalUrl']));
    }
}
