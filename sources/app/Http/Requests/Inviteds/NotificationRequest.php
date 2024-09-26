<?php

namespace App\Http\Requests\Inviteds;

use Illuminate\Foundation\Http\FormRequest;

require_once dirname(__DIR__, 3) . '/Domain/Constants/FieldConst.php';

class NotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            FIELD_EMAIL             => ['required', 'string', ],
            FIELD_INVITED_USER_ID   => ['required', 'numeric',],
            FIELD_EVENT_ID          => ['required', 'numeric',],
        ];
    }
}
