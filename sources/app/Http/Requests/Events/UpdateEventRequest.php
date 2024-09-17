<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;

require_once dirname(__DIR__, 3) . '/Domain/Constants/FieldConst.php';

class UpdateEventRequest extends FormRequest
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
            FIELD_ID                => ['required', 'numeric', 'exists:events,id'],
            FIELD_NAME              => ['nullable', 'string', 'min:5', 'max:255'],
            FIELD_DESCRIPTION       => ['nullable', 'string'],
            FIELD_IMAGE             => ['nullable', 'string', 'max:255', 'exists:files,key'],
            FIELD_LOCATION          => ['nullable', 'string', 'max:255'],
            FIELD_STATUS            => ['nullable', 'string'],
            FIELD_START_DATE        => ['nullable'],
            FIELD_START_TIME        => ['nullable'],
            FIELD_EXPIRATION_DATE   => ['nullable'],
            FIELD_EXPIRATION_TIME   => ['nullable'],
        ];
    }
}
