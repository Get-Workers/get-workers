<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SpecialtyWorker extends Pivot
{
    /**
     * @return BelongsTo
     */
    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    /**
     * @return BelongsTo
     */
    public function specialty(): BelongsTo
    {
        return $this->belongsTo(Specialty::class);
    }
}
