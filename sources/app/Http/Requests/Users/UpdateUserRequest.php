<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'id'                => ['required'],
            'first_name'        => ['nullable', 'min:2', 'max:255'],
            'first_name_eng'    => ['nullable', 'min:2', 'max:255'],
            'last_name'         => ['nullable', 'min:2', 'max:255'],
            'last_name_eng'     => ['nullable', 'min:2', 'max:255'],
            'birth_date'        => ['nullable'],
            'gender'            => ['nullable'],
            'email'             => ['nullable', 'min:8', 'max:255', 'unique:users'],
            'phone'             => ['nullable', 'max:20', 'unique:users'],
            'location'          => ['nullable'],
            'password'          => ['nullable', 'min:8', 'max:30'],
        ];
    }
}
