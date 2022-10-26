<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Casts\Attribute;
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
        'scheduled_to',
        'initiated_at',
        'done_at',
    ];

    protected $casts = [
        'scheduled_to' => 'datetime',
        'initiated_at' => 'timestamp',
        'done_at' => 'timestamp',
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

    /**
     * @return Attribute
     */
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn (?int $value) => (float) ($value / 100),
            set: fn (?float $value) => (int) ($value * 100),
        );
    }

    /**
     * @return Attribute
     */
    protected function valuePaid(): Attribute
    {
        return Attribute::make(
            get: fn (?int $value) => (! is_null($value)) ? ((float) ($value / 100)) : $value,
            set: fn (?float $value) => (! is_null($value)) ? ((int) ($value * 100)) : $value,
        );
    }
}
