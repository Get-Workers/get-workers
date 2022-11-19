<?php

namespace App\Services\Caches;

use App\Models\Specialty;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class SpecialtyCacheService
{
    /**
     * @param  bool  $clear
     *
     * @return Collection|null
     */
    public static function all(bool $clear = false): ?Collection
    {
        $key = 'specialty:all';

        if ($clear) {
            Cache::forget($key);
            return null;
        }

        return Cache::remember($key, now()->addHour(), fn () => Specialty::all());
    }
}
