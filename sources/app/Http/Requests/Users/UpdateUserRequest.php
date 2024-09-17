<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

require_once dirname(__DIR__, 3) . '/Domain/Constants/FieldConst.php';

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
            FIELD_ID                => ['required'],
            FIELD_FIRST_NAME        => ['nullable', 'min:2', 'max:255'],
            FIELD_FIRST_NAME_ENG    => ['nullable', 'min:2', 'max:255'],
            FIELD_LAST_NAME         => ['nullable', 'min:2', 'max:255'],
            FIELD_LAST_NAME_ENG     => ['nullable', 'min:2', 'max:255'],
            FIELD_BIRTH_DATE        => ['nullable'],
            FIELD_GENDER            => ['nullable'],
            FIELD_EMAIL             => ['nullable', 'min:8', 'max:255', 'unique:users'],
            FIELD_PHONE             => ['nullable', 'max:20', 'unique:users'],
            FIELD_LOCATION          => ['nullable'],
            FIELD_PASSWORD          => ['nullable', 'min:8', 'max:30'],
        ];
    }

    public function messages()
    {
        return [
            FIELD_ID . '.required'              => 'ID - это обязательное поле!',

            FIELD_FIRST_NAME . '.required'      => 'Имя - это обязательное поле!',
            FIELD_FIRST_NAME . '.min'           => 'Имя не может быть меньше :min-х символов!',
            FIELD_FIRST_NAME . '.max'           => 'Имя не может быть больше :max-х символов!',

            FIELD_FIRST_NAME_ENG . '.required'  => 'Имя на латинице - это обязательное поле!',
            FIELD_FIRST_NAME_ENG . '.min'       => 'Имя на латинице не может быть меньше :min-х символов!',
            FIELD_FIRST_NAME_ENG . '.max'       => 'Имя на латинице не может быть больше :max-х символов!',

            FIELD_LAST_NAME . '.required'       => 'Фамилия - это обязательное поле!',
            FIELD_LAST_NAME . '.min'            => 'Фамилия не может быть меньше :min-х символов!',
            FIELD_LAST_NAME . '.max'            => 'Фамилия не может быть больше :max-х символов!',

            FIELD_LAST_NAME_ENG . '.required'   => 'Фамилия на латинице - это обязательное поле!',
            FIELD_LAST_NAME_ENG . '.min'        => 'Фамилия на латинице не может быть меньше :min-х символов!',
            FIELD_LAST_NAME_ENG . '.max'        => 'Фамилия на латинице не может быть больше :max-х символов!',

            FIELD_EMAIL . '.min'                => 'Электронная почта не может быть меньше :min-ми символов!',
            FIELD_EMAIL . '.max'                => 'Электронная почта не может быть больше :max символов!',
            FIELD_EMAIL . '.unique'             => 'Электронная почта введена не правильно!',

            FIELD_PHONE . '.max'                => 'Не правильно введён формат номера телефона!',
            FIELD_PHONE . '.unique'             => 'Не правильно введён формат номера телефона!',

            FIELD_PASSWORD . '.required'        => 'Пароль - это обязательное поле!',
            FIELD_PASSWORD . '.min'             => 'Пароль не может быть меньше :min-х символов!',
            FIELD_PASSWORD . '.max'             => 'Пароль не может быть больше :max-х символов!',
        ];
    }
}
