<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ReviewHiredWorkContractor extends Pivot
{
    public $timestamps = false;

    /**
     * @return BelongsTo
     */
    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class);
    }

    /**
     * @return BelongsTo
     */
    public function hiredWork(): BelongsTo
    {
        return $this->belongsTo(HiredWork::class);
    }
}
