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
            'id'                => ['required', 'numeric'],
            'user_id'           => ['required', 'numeric'],
            'key'               => ['required'],
            'name'              => ['required', 'string', 'min:5', 'max:255'],
            'description'       => ['required', 'string'],
            'image'             => ['required', 'string', 'max:255'],
            'start_date'        => ['required'],
            'start_time'        => ['required'],
            'expiration_date'   => ['required'],
            'expiration_time'   => ['required'],
        ];
    }
}
