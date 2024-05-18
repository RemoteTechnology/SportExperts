<?php

namespace App\Http\Requests\Options;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOptionRequest extends FormRequest
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
            'id'                => ['required', 'numeric'],
            'event_key'         => ['required'],
            'participant_key'   => ['required'],
            'entity'            => ['required', 'string'],
            'name'              => ['required', 'string', 'min:2', 'max:255'],
            'value'             => ['required', 'string', 'min:2', 'max:255'],
            'type'              => ['required', 'string'],
        ];
    }
}
