<?php

namespace App\Actions\Worker\Profile;

use App\Models\Worker;

class UpdateCnpjAction
{
    public function update(Worker $worker, string $cnpj): bool
    {
        $worker->cnpj = $cnpj;
        return $worker->save();
    }
}
