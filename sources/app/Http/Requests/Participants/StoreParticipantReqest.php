<?php

namespace App\Http\Requests\Participants;

use Illuminate\Foundation\Http\FormRequest;

class StoreParticipantReqest extends FormRequest
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
            'events_id'     => ['required', 'numeric'],
            'users_id'      => ['required', 'numeric'],
            'team_key'      => ['required'],
            'key'           => ['required'],
            'first_name'    => ['required', 'string', 'min:2', 'max:255'],
            'last_name'     => ['required', 'string', 'min:2', 'max:255'],
            'birth_date'    => ['required'],
            'email'         => ['required', 'string', 'max:255'],
            'phone'         => ['required', 'string', 'max:18'],
            'gender'        => ['required', 'string', 'max:255'],
            'location'      => ['required', 'string', 'max:255'],
        ];
    }
}
