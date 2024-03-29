<?php

namespace App\Models;

use App\Models\Traits\Uuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Certification extends Model
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
        'name',
        'description',
        'certified_uuid',
        'certified_link',
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
    public function worker(): BelongsTo
    {
        return $this->belongsTo(Worker::class);
    }
}
