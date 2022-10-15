<?php

namespace App\Actions\Work\ContractedWork;

use App\Models\ContractedWork;
use App\Models\Contractor;
use App\Models\Work;

class StoreContractedWork
{
    public function storeContractedWork(Contractor $contractor, Work $work): void
    {
        $contractedWork = new ContractedWork([
            'price' => $work->price,
        ]);
        $contractedWork->work()->associate($work);
        $contractor->contractedWorks()->save($contractedWork);
    }
}
