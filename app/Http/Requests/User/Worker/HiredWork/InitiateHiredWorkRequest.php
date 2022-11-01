<?php

namespace App\Http\Requests\User\Worker\HiredWork;

use App\Rules\ValidateHiredWorkIsInitiated;
use App\Rules\ValidateHiredWorkIsNotInitiated;
use App\Rules\ValidateWorkerOwnHiredWork;
use Illuminate\Foundation\Http\FormRequest;

class InitiateHiredWorkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();
        if (is_null($user)) {
            return false;
        }

        return (! is_null($user->worker));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'hiredWork' => [
                'required',
                'uuid',
                'exists:hired_works,uuid',
                new ValidateHiredWorkIsInitiated,
                new ValidateWorkerOwnHiredWork,
            ],
        ];
    }
}
