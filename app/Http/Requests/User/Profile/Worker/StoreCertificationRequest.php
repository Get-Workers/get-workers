<?php

namespace App\Http\Requests\User\Profile\Worker;

use Illuminate\Foundation\Http\FormRequest;

class StoreCertificationRequest extends FormRequest
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
            'name' => 'required|min:1|max:255',
            'description' => 'nullable|max:1024',
            'certified_uuid' => 'nullable|max:100|unique:certifications,certified_uuid',
            'certified_link' => 'nullable|max:255|unique:certifications,certified_link',
        ];
    }
}
