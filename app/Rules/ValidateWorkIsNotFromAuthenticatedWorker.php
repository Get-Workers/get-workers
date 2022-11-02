<?php

namespace App\Rules;

use App\Models\Work;
use Illuminate\Contracts\Validation\InvokableRule;

class ValidateWorkIsNotFromAuthenticatedWorker implements InvokableRule
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
        $worker = auth()->user()->worker;
        if (is_null($worker)) return;

        $work = Work::whereUuid($value)
            ->where('worker_id', '!=', $worker->id)
            ->first();
        if (! is_null($work)) return;
        $fail('validation.work_is_not_from_authenticated_worker')->translate();
    }
}
