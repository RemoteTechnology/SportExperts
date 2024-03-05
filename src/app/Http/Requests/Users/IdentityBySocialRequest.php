<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class IdentityBySocialRequest extends FormRequest
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
            'vk_id'                     => ['nullable'],
            'vk_sid_token'              => ['nullable'],
            'vk_sig_token'              => ['nullable'],

            'google_id'                 => ['nullable'],
            'google_access_token'       => ['nullable'],

            'first_name'                => ['required'],
            'last_name'                 => ['required'],
            'first_name_eng'            => ['required'],
            'last_name_eng'             => ['required'],
            'email'                     => ['nullable'],
        ];
    }
    public function messages()
    {
        return [
            'first_name.required'       => 'Имя не указано!',
            'last_name.required'        => 'Фамилия не указанна!',
            'first_name_eng.required'   => 'Имя на латинице не указано!',
            'last_name_eng.required'    => 'Фамилия на латинице не указанна!',
        ];
    }
}
