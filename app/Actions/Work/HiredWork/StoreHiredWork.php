<?php

namespace App\Actions\Work\HiredWork;

use App\Models\HiredWork;
use App\Models\Contractor;
use App\Models\Work;

class StoreHiredWork
{
    public function storeHiredWork(Contractor $contractor, Work $work, array $data = []): void
    {
        $hiredWork = new HiredWork([
            'price' => $work->price,
            ...$data,
        ]);
        $hiredWork->work()->associate($work);
        $contractor->hiredWorks()->save($hiredWork);
    }
}
