<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Specialty extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * @return BelongsToMany
     */
    public function workers(): BelongsToMany
    {
        return $this->belongsToMany(Worker::class)->using(SpecialtyWorker::class);
    }

    /**
     * @return BelongsToMany
     */
    public function works(): BelongsToMany
    {
        return $this->belongsToMany(Work::class)->using(SpecialtyWorker::class);
    }
}
