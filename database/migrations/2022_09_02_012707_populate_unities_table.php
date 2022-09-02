<?php

use App\Models\Unity;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    private const BASE_UNITIES = [
        ['name' => 'square meter', 'slug' => 'square-meter', 'type' => 'm2'],
        ['name' => 'square centimeter', 'slug' => 'square-centimeter', 'type' => 'cm2'],
        ['name' => 'minute', 'slug' => 'minute', 'type' => 'm'],
        ['name' => 'hour', 'slug' => 'hour', 'type' => 'h'],
        ['name' => 'item', 'slug' => 'item', 'type' => 'item'],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (self::BASE_UNITIES as $unity) {
            Unity::firstOrCreate($unity, $unity);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('unities')->truncate();
    }
};
