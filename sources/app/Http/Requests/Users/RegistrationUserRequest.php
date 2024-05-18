<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationUserRequest extends FormRequest
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
            'first_name'        => ['required', 'min:2', 'max:255'],
            'first_name_eng'    => ['required', 'min:2', 'max:255'],
            'last_name'         => ['required', 'min:2', 'max:255'],
            'last_name_eng'     => ['required', 'min:2', 'max:255'],
            'birth_date'        => ['nullable'],
            'gender'            => ['nullable'],
            'email'             => ['nullable', 'min:8', 'max:255', 'unique:users'],
            'phone'             => ['nullable', 'max:18', 'unique:users'],
            'location'          => ['nullable'],
            'password'          => ['required', 'min:8', 'max:30'],
        ];
    }
}
