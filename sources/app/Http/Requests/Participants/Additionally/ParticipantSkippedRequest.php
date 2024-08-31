<?php

namespace App\Http\Requests\Participants\Additionally;

use Illuminate\Foundation\Http\FormRequest;

class ParticipantSkippedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'participants_A'        => ['nullable', 'string'],
            'participants_B'        => ['nullable', 'string']
        ];
    }
}
