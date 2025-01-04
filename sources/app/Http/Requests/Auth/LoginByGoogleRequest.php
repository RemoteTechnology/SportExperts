<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

require_once dirname(__DIR__, 3) . '/Domain/Constants/FieldConst.php';

class LoginByGoogleRequest extends FormRequest
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
            FIELD_GOOGLE_ID         => ['required'],
            FIELD_FIRST_NAME        => ['required', 'min:2', 'max:255'],
            FIELD_FIRST_NAME_ENG    => ['required', 'min:2', 'max:255'],
            FIELD_LAST_NAME         => ['required', 'min:2', 'max:255'],
            FIELD_LAST_NAME_ENG     => ['required', 'min:2', 'max:255'],
            FIELD_ROLE              => ['nullable'],
            FIELD_EMAIL             => ['required', 'min:8', 'max:255', 'unique:users'],
        ];
    }
}
