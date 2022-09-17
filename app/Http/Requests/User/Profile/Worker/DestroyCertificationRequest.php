<?php

namespace App\Http\Requests\User\Profile\Worker;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DestroyCertificationRequest extends FormRequest
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
            'certification' => [
                'required',
                'string',
                Rule::exists('certifications', 'uuid')
                    ->where('worker_id', auth()->user()->worker->id)
            ]
        ];
    }
}
