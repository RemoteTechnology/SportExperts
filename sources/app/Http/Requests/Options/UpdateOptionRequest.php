<?php

namespace App\Http\Requests\Options;

use Illuminate\Foundation\Http\FormRequest;

require_once dirname(__DIR__, 3) . '/Domain/Constants/FieldConst.php';

class UpdateOptionRequest extends FormRequest
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
            FIELD_ID                => ['required', 'numeric', 'exists:options,id'],
            FIELD_EVENT_KEY         => ['nullable', 'exists:event,key'],
            FIELD_PARTICIPANT_KEY   => ['nullable', 'exists:participants,key'],
            FIELD_ENTITY            => ['required', 'string'],
            FIELD_NAME              => ['required', 'string', 'min:2', 'max:255'],
            FIELD_VALUE             => ['required', 'string', 'min:2', 'max:255'],
            FIELD_TYPE              => ['required', 'string'],
        ];
    }
}
