<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

require_once dirname(__DIR__, 3) . '/Domain/Constants/FieldConst.php';

class LoginByEmailRequest extends FormRequest
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
            FIELD_EMAIL     => ['required', 'min:8', 'max:255', 'exists:users,email'],
            FIELD_PASSWORD  => ['required', 'max:30'],
        ];
    }

    public function messages()
    {
        return [
            FIELD_EMAIL . '.required'           => 'Электронная почта - это обязательное поле!',
            FIELD_EMAIL . '.min'                => 'Электронная почта не может быть меньше :min-ми символов!',
            FIELD_EMAIL . '.max'                => 'Электронная почта не может быть больше :max символов!',
            FIELD_EMAIL . '.exists'             => 'Не правильно введён адрес электронной почты!',

            FIELD_PASSWORD . '.required'        => 'Пароль - это обязательное поле!',
            FIELD_PASSWORD . '.max'             => 'Пароль не может быть больше :max-х символов!',
        ];
    }
}
