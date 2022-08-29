<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

trait Uuid
{
    private function initiateUuid(?string $key): void
    {
        self::creating(function (Model $model) {
            $model->{$key ?? $model->primaryKey} = (string) Str::uuid();
        });
    }
}
