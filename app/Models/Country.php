<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'id',
        'name',
        'name_pt',
        'short_name',
        'bacen',
    ];

    public $timestamps = false;
}
