<?php

namespace App\Http\Requests\Options;

use Illuminate\Foundation\Http\FormRequest;

class ReadOptionRequest extends FormRequest
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
            'id'        => ['nullable', 'numeric', 'exists:options,id'],
            'user_id'   => ['nullable', 'numeric', 'exists:options,user_id'],
            'event_key' => ['nullable', 'string', 'exists:options,event_key'],
        ];
    }
}
