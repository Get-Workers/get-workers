<?php

namespace App\Http\Requests\User\Worker;

use App\Rules\ValidateWorkIsFromAuthenticatedWorker;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMyWorkRequest extends FormRequest
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
            'id' => 'required|integer|exists:works',
            'uuid' => new ValidateWorkIsFromAuthenticatedWorker,
            'name' => 'required|string|min:5|max:255',
            'description' => 'nullable|string|min:10|max:512',
            'time' => 'nullable|string|date_format:H:i',
            'price' => 'nullable|numeric|min:0|max:10000000',
            'unity_id' => 'nullable|integer|required_if:has_unity,true|exists:unities,id',
            'specialties' => 'nullable|array|exists:specialties,id',
        ];
    }
}
