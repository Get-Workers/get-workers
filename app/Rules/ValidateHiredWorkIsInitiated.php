<?php

namespace App\Rules;

use App\Models\HiredWork;
use Illuminate\Contracts\Validation\InvokableRule;

class ValidateHiredWorkIsInitiated implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $hiredWork = HiredWork::whereUuid($value)->firstOrFail();
        if (is_null($hiredWork->initiated_at)) return;

        $fail('validation.hired_work_is_initiated')->translate();
    }
}
