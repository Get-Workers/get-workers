<?php

namespace App\Actions\Work\HiredWork;

use App\Models\HiredWork;
use App\Models\Contractor;
use App\Models\Work;

class StoreHiredWork
{
    public function storeHiredWork(Contractor $contractor, Work $work): void
    {
        $hiredWork = new HiredWork([
            'price' => $work->price,
        ]);
        $hiredWork->work()->associate($work);
        $contractor->hiredWorks()->save($hiredWork);
    }
}
