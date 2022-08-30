<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait Uuid
{
    private static function initiateUuid(?string $key): void
    {
        self::creating(function (Model $model) use (&$key) {
            $model->{$key ?? $model->primaryKey} = (string) Str::uuid();
        });
    }
}
