<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

require_once dirname(__DIR__, 3) . '/Domain/Constants/FieldConst.php';

class ResetRequest extends FormRequest
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
            FIELD_EMAIL => ['nullable', 'min:8', 'max:255', 'exists:users,email'],
        ];
    }

    public function messages()
    {
        return [
            FIELD_EMAIL . '.min'        => 'Электронная почта не может быть меньше :min-ми символов!',
            FIELD_EMAIL . '.max'        => 'Электронная почта не может быть больше :max символов!',
            FIELD_EMAIL . '.exists'     => 'Такого пользователя в системе не существует!',
        ];
    }
}
