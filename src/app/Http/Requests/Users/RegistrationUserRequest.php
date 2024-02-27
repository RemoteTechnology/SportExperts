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
            'first_name'                => ['required', 'max:30'],
            'first_name_eng'            => ['required'],
            'last_name'                 => ['required', 'max:30'],
            'last_name_eng'             => ['required'],
            'birth_date'                => ['nullable'],
            'gender'                    => ['nullable'],
            'email'                     => ['required'],
            'is_admin'                  => ['nullable'],
            'password'                  => ['nullable'],
        ];
    }
    public function messages()
    {
        return [
            'first_name.required'       => 'Имя - обязательный параметр!',
            'first_name.max'            => 'Имя не может превышать :max символов!',
            'first_name_eng.required'   => 'Имя на латинице - обязательный параметр!',

            'last_name.required'        => 'Фамилия - обязательный параметр!',
            'last_name.max'             => 'Фамилия не может превышать :max символов!',
            'last_name_eng.required'    => 'Фамилия на латинице - обязательный параметр!',

            'email.required'            => 'Укажите почту',
        ];
    }
}
