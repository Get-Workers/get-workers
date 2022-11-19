<?php

namespace App\Http\Requests\User\Worker;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkerPhoneNumbersRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (! is_null(auth()->user()->worker));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'phoneNumbers' => 'nullable|array|max:3',
            'phoneNumbers.*.phone_number.number' => [
                'required',
                'string',
                'min:15',
                'max:15',
                'distinct',
            ],
        ];
    }
}
