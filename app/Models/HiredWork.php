<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HiredWork extends Model
{
    use HasFactory;
    use Uuid;

    protected $fillable = [
        'work_id',
        'contractor_id',
        'price',
        'value_paid',
        'initiated_at',
        'done_at',
    ];

    /**
     *
     * Register any events for your application.
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();
        self::initiateUuid('uuid');
    }

    /**
     * @return BelongsTo
     */
    public function contractor(): BelongsTo
    {
        return $this->belongsTo(Contractor::class);
    }

    /**
     * @return BelongsTo
     */
    public function work(): BelongsTo
    {
        return $this->belongsTo(Work::class);
    }
}
