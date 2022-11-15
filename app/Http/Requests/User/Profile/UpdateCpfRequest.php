<?php

namespace App\Http\Requests\User\Profile;

use App\Models\User;
use App\Rules\IsCpfValid;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCpfRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (! is_null(auth()->user()));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $user = auth()->user();
        $actualCpf = $user->cpf ?? '';

        return [
            'cpf' => [
                'required',
                "not_in:{$actualCpf}",
                Rule::unique(User::class)
                    ->whereNot('id', $user->id),
                new IsCpfValid,
            ],
        ];
    }
}
