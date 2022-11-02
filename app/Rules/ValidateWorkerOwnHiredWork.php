<?php

namespace App\Rules;

use App\Services\Caches\HiredWorkCacheService;
use Illuminate\Contracts\Validation\InvokableRule;

class ValidateWorkerOwnHiredWork implements InvokableRule
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
        $worker = auth()->user()->worker;
        $hiredWork = HiredWorkCacheService::findUuid($value, 'work.worker');
        if ($worker->id !== $hiredWork->work->worker->id) {
            $fail('validation.worker_do_not_own_hired_work')->translate();
        }
    }
}
