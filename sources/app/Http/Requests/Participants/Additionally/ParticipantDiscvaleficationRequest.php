<?php

namespace App\Http\Requests\Participants\Additionally;

use Illuminate\Foundation\Http\FormRequest;

class ParticipantDiscvaleficationRequest extends FormRequest
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
            'event_id'      => ['required', 'numeric'],
            'participant_A' => ['nullable', 'string'],
            'participant_B' => ['nullable', 'string'],
        ];
    }
}
