<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
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
            'id'                => ['required', 'numeric', 'exists:events,id'],
            'user_id'           => ['required', 'numeric', 'exists:users,id'],
            'name'              => ['nullable', 'string', 'min:5', 'max:255'],
            'description'       => ['nullable', 'string'],
            'image'             => ['nullable', 'string', 'max:255', 'exists:files,key'],
            'start_date'        => ['nullable'],
            'start_time'        => ['nullable'],
            'expiration_date'   => ['nullable'],
            'expiration_time'   => ['nullable'],
        ];
    }
}
