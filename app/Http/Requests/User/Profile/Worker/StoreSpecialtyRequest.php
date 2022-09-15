<?php

namespace App\Http\Requests\User\Profile\Worker;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSpecialtyRequest extends FormRequest
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
        $workerId = auth()->user()->worker->id;
        return [
            'specialty' => [
                'exists:specialties,id',
                Rule::unique('specialty_worker', 'specialty_id')
                    ->where(fn ($query) => $query->where('worker_id', $workerId)),
            ]
        ];
    }
}
