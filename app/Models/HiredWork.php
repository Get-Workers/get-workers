<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

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

    protected $appends = [
        'contractor_review',
        'worker_review',
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
     * @return HasMany
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * @return Attribute
     */
    protected function contractorReview(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (! $this->relationLoaded('reviews')) return null;
                return $this->reviews
                    ->whereNotNull('contractor_id')
                    ->first();
            },
        );
    }

    /**
     * @return Attribute
     */
    protected function workerReview(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (! $this->relationLoaded('reviews')) return null;
                return $this->reviews
                    ->whereNotNull('worker_id')
                    ->first();
            },
        );
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

    /**
     * @param  Builder  $query
     * @param  array  $filters
     * @return Builder
     */
    public function scopeFilter(Builder $query, array $filters = []): Builder
    {
        if (array_key_exists('scheduled_to', $filters)) {
            $query->whereNotNull('scheduled_to');
        }
        return $query;
    }

    /**
     * @param  Builder  $query
     * @param  int  $rating
     * @return Builder
     */
    public function scopeWithRatingMoreThan(Builder $query, int $rating): Builder
    {
        return $query->whereHas(
            'reviews',
            fn (Builder $query) =>
                $query->select(DB::raw('AVG(reviews.rating) as average_rating'))
                    ->having('average_rating', '>=', $rating)
        );
    }
}
