<?php

namespace App\Http\Requests\User\Profile;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePhoneNumberRequest extends FormRequest
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
        $actualPhoneNumber = $user->phone_number ?? '';

        return [
            'phoneNumber' => [
                'required',
                'min:15',
                'max:15',
                "not_in:{$actualPhoneNumber}",
                Rule::unique(User::class, 'phone_number')
                    ->whereNot('id', $user->id),
            ],
        ];
    }
}
