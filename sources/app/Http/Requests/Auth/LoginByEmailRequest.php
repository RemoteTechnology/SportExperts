<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
            FIELD_LOGIN     => ['required', 'min:8', 'max:255',
//                Rule::exists('users', 'email')->where(function ($query) {
//                    return $query->where('email', $this->login)
//                            ->orWhere('phone', $this->login);
//                }),
                ],
            FIELD_PASSWORD  => ['required', 'max:30'],
        ];
    }

    public function messages()
    {
        return [
            FIELD_LOGIN . '.required'           => 'Логин - это обязательное поле!',
            FIELD_LOGIN . '.min'                => 'Логин не может быть меньше :min-ми символов!',
            FIELD_LOGIN . '.max'                => 'Логин не может быть больше :max символов!',
            //FIELD_LOGIN . '.exists'             => 'Не правильно введён логин!',

            FIELD_PASSWORD . '.required'        => 'Пароль - это обязательное поле!',
            FIELD_PASSWORD . '.max'             => 'Пароль не может быть больше :max-х символов!',
        ];
    }
}
