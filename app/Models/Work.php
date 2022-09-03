<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        'unity_price',
    ];

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
}
