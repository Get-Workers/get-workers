<?php

namespace App\Rules;

use App\Services\Caches\HiredWorkCacheService;
use Illuminate\Contracts\Validation\InvokableRule;

class ValidateHiredWorkIsDone implements InvokableRule
{
    /**
     * Run the validation rule.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @param  \Closure  $fail
     * @return void
     */
    public function __invoke($attribute, $value, $fail)
    {
        $hiredWork = HiredWorkCacheService::findUuid($value);
        if (! is_null($hiredWork->done_at)) {
            $fail('validation.hired_work_is_already_done')->translate();
        }
    }
}
