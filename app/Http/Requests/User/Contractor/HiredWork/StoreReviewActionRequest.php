<?php

namespace App\Http\Requests\User\Contractor\HiredWork;

use App\Rules\ValidateWorkIsNotFromAuthenticatedWorker;
use Illuminate\Foundation\Http\FormRequest;

class StoreReviewActionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user = auth()->user();
        if (is_null(auth()->user())) {
            return false;
        }

        return (! is_null($user->contractor));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'rating' => 'required|between:1,5',
        ];
    }
}
