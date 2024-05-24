<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;

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
            'user_id'           => ['required', 'numeric', 'exists:users,id'],
            'name'              => ['required', 'string', 'min:5', 'max:255'],
            'description'       => ['required', 'string'],
            'image'             => ['required', 'string', 'max:255', 'exists:files,key'],
            'start_date'        => ['required'],
            'start_time'        => ['required'],
            'expiration_date'   => ['required'],
            'expiration_time'   => ['required'],
        ];
    }
}
