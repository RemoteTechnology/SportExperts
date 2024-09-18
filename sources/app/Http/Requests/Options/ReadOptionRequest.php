<?php

namespace App\Http\Requests\Options;

use Illuminate\Foundation\Http\FormRequest;

require_once dirname(__DIR__, 3) . '/Domain/Constants/FieldConst.php';

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
            FIELD_ID        => ['nullable', 'numeric', 'exists:options,id'],
            FIELD_USER_ID   => ['nullable', 'numeric', 'exists:options,user_id'],
            FIELD_EVENT_KEY => ['nullable', 'string', 'exists:options,event_key'],
        ];
    }
}
