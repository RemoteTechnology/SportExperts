<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

require_once dirname(__DIR__, 3) . '/Domain/Constants/FieldConst.php';

class ReadUserRequest extends FormRequest
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
            FIELD_ID => ['required', 'exists:users,id']
        ];
    }

    public function messages()
    {
        return [
            FIELD_ID . '.required'  => 'ID - это обязательное поле!',
            FIELD_ID . '.exists'    => 'Такого пользователя в системе не существует!',
        ];
    }
}
