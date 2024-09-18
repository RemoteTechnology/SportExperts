<?php

namespace App\Http\Requests\Archives;

use Illuminate\Foundation\Http\FormRequest;

require_once dirname(__DIR__, 3) . '/Domain/Constants/FieldConst.php';

class ArchiveRequest extends FormRequest
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
            FIELD_KEY => ['required', 'exists:events,key'],
        ];
    }
}
