<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Work extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Uuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'worker_id',
        'unity_id',
        'name',
        'slug',
        'description',
        'time',
        'price',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'time' => 'datetime:H:i',
    ];

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
    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => str($value)->slug()
        );
    }

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
    public function unity(): BelongsTo
    {
        return $this->belongsTo(Unity::class);
    }

    /**
     * @return BelongsTo
     */
    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }

    /**
     * @return HasMany
     */
    public function hiredWorks(): HasMany
    {
        return $this->hasMany(HiredWork::class);
    }

    /**
     * @return BelongsToMany
     */
    public function specialties(): BelongsToMany
    {
        return $this->belongsToMany(Specialty::class)->using(SpecialtyWork::class);
    }

    /**
     * @param  Builder  $query
     * @param  array  $filters
     * @return Builder
     */
    public function scopeFilter(Builder $query, array $filters = []): Builder
    {
        if (! empty($filters['search'])) {
            $query->where(function (Builder $query) use (&$filters) {
                $query->search($filters['search']);
            });
        }

        if (! empty($filters['moreHires']) && $filters['moreHires']) {
            $query->moreHires();
        }

        if (! empty($filters['stars']) && $filters['stars'] > 0) {
            $query->minStars($filters['stars']);
        }

        if (! empty($filters['specialties'])) {
            $query->withSpecialties($filters['specialties']);
        }

        if (! empty($filters['city'])) {
            $query->withCity($filters['city']);
        }

        return $query;
    }

    /**
     * @param  Builder  $query
     * @param  string  $search
     * @return Builder
     */
    public function scopeSearch(Builder $query, string $search): Builder
    {
        return $query->where('works.name', 'like', "%{$search}%")
            ->orWhere('works.slug', 'like', "%{$search}%")
            ->orWhere('works.uuid', $search);
    }

    /**
     * @param  Builder  $query
     * @return Builder
     */
    public function scopeMoreHires(Builder $query): Builder
    {
        return $query->withCount('hiredWorks')
            ->orderByDesc('hired_works_count');
    }

    /**
     * @param  Builder  $query
     * @param  int  $minStars
     * @return Builder
     */
    public function scopeMinStars(Builder $query, int $minStars): Builder
    {
        if ($minStars === 0) {
            return $query;
        }

        return $query->whereHas(
            'hiredWorks',
            fn (Builder $query) => $query->withRatingMoreThan($minStars)
        );
    }

    /**
     * @param  Builder  $query
     * @param  array  $specialties
     * @return Builder
     */
    public function scopeWithSpecialties(Builder $query, array $specialties): Builder
    {
        return $query->whereHas('specialties', fn (Builder $query) => $query->whereIn('id', $specialties));
    }

    public function scopeWithCity(Builder $query, int $cityId): Builder
    {
        return $query->whereHas('worker.user', fn (Builder $query) => $query->whereCityId($cityId));
    }
}
