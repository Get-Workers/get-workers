<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        'regular_time',
        'regular_price',
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
     * @return HasOne
     */
    public function contractedWork(): HasOne
    {
        return $this->hasOne(ContractedWork::class);
    }

    /**
     * @return BelongsToMany
     */
    public function specialties(): BelongsToMany
    {
        return $this->belongsToMany(Specialty::class)->using(SpecialtyWork::class);
    }

    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn (?int $value) => (float) ($value / 100),
            set: fn (?float $value) => (int) ($value * 100),
        );
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => str($value)->slug()
        );
    }
}
