<?php

namespace App\Http\Requests\Participants\Additionally;

use Illuminate\Foundation\Http\FormRequest;

class ParticipantReplacementRequest extends FormRequest
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
            'event_id'              => ['required', 'numeric'],
            'new_participant_key'   => ['required', 'string'],
            'participant_key'       => ['required', 'string'],
        ];
    }
}
