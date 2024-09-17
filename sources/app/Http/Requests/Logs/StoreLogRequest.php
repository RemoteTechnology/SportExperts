<?php

namespace App\Http\Requests\Logs;

use Illuminate\Foundation\Http\FormRequest;

require_once dirname(__DIR__, 3) . '/Domain/Constants/FieldConst.php';

class StoreLogRequest extends FormRequest
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
            FIELD_CURRENT_DATE  => ['required',  'string'],
            FIELD_CURRENT_TIME  => ['required',  'string'],
            FIELD_METHOD        => ['required',  'string'],
            FIELD_STATUS        => ['required'],
            FIELD_REQUEST_DATA  => ['required', 'string'],
            FIELD_MESSAGE       => ['required',  'string'],
        ];
    }
}
