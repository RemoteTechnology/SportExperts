<?php

namespace App\Http\Requests\Logs;

use Illuminate\Foundation\Http\FormRequest;

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
            'current_date' => ['required',  'string'],
            'current_time' => ['required',  'string'],
            'method' => ['required',  'string'],
            'status' => ['required'],
            'request_data' => ['required', 'string'],
            'message' => ['required',  'string'],
        ];
    }
}
