<?php

namespace App\Services\Caches;

use App\Models\Unity;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class UnityCacheService
{
    /**
     * @param  bool  $clear
     *
     * @return Collection|null
     */
    public static function all(bool $clear = false): ?Collection
    {
        $key = 'unity:all';

        if ($clear) {
            Cache::forget($key);
            return null;
        }

        return Cache::rememberForever($key, fn () => Unity::all());
    }
}
