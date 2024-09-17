<?php

namespace App\Http\Requests\Teams;

use Illuminate\Foundation\Http\FormRequest;

require_once dirname(__DIR__, 3) . '/Domain/Constants/FieldConst.php';

class StoreTeamRequest extends FormRequest
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
            FIELD_USER_ID       => ['required', 'numeric', 'exists:users,id'],
            FIELD_NAME          => ['required', 'string', 'min:6', 'max:255'],
            FIELD_DESCRIPTION   => ['required', 'string'],
            FIELD_IMAGE         => ['required', 'string', 'max:255', 'exists:files,key'],
            FIELD_LOCATION      => ['required', 'string', 'max:255'],
        ];
    }
}
