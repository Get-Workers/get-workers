<?php

namespace App\Actions\Worker\Profile;

use App\Models\Worker;

class UpdateCnpjAction
{
    /**
     * @param  Worker  $worker
     * @param  string  $cnpj
     * @return boolean
     */
    public function update(Worker $worker, string $cnpj): bool
    {
        $worker->cnpj = $cnpj;
        return $worker->save();
    }
}
