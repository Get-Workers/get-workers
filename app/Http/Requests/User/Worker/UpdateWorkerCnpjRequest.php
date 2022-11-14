<?php

namespace App\Http\Requests\User\Worker;

use App\Models\Worker;
use App\Rules\IsCnpjValid;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateWorkerCnpjRequest extends FormRequest
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
        $worker = auth()->user()->worker;
        $actualCnpj = $worker->cnpj ?? '';

        return [
            'cnpj' => [
                "not_in:{$actualCnpj}",
                Rule::unique(Worker::class)
                    ->whereNot('id', $worker->id),
                new IsCnpjValid,
            ],
        ];
    }
}
