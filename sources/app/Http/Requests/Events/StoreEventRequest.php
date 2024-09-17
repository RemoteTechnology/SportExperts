<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;

require_once dirname(__DIR__, 3) . '/Domain/Constants/FieldConst.php';

class StoreEventRequest extends FormRequest
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
            FIELD_USER_ID           => ['required', 'numeric', 'exists:users,id'],
            FIELD_NAME              => ['required', 'string', 'min:5', 'max:255'],
            FIELD_DESCRIPTION       => ['required', 'string'],
            FIELD_IMAGE             => ['required', 'string', 'max:255', 'exists:files,key'],
            FIELD_LOCATION          => ['required', 'string', 'max:255'],
            FIELD_STATUS            => ['nullable', 'string'],
            FIELD_START_DATE        => ['required'],
            FIELD_START_TIME        => ['required'],
            FIELD_EXPIRATION_DATE   => ['required'],
            FIELD_EXPIRATION_TIME   => ['required'],
        ];
    }
}
