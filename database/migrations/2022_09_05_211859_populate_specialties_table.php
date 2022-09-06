<?php

use App\Models\Specialty;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private const BASE_SPECIALTIES = [
        ['name' => 'woodwork', 'slug' => 'woodwork',],
        ['name' => 'carpentry', 'slug' => 'carpentry',],
        ['name' => 'gardening', 'slug' => 'gardening',],
        ['name' => 'fruitgrowing', 'slug' => 'fruitgrowing',],
        ['name' => 'horticulture', 'slug' => 'horticulture',],
        ['name' => 'janitor', 'slug' => 'janitor',],
        ['name' => 'painter', 'slug' => 'painter',],
        ['name' => 'plumber', 'slug' => 'plumber',],
        ['name' => 'mason', 'slug' => 'mason',],
        ['name' => 'electrician', 'slug' => 'electrician',],
        ['name' => 'developer', 'slug' => 'developer',],
        ['name' => 'programmer', 'slug' => 'programmer',],
        ['name' => 'leader', 'slug' => 'leader',],
        ['name' => 'choffeaur', 'slug' => 'choffeaur',],
        ['name' => 'mechanic', 'slug' => 'mechanic',],
        ['name' => 'engineer', 'slug' => 'engineer',],
        ['name' => 'software engineer', 'slug' => 'software-engineer',],
        ['name' => 'mechanical engineer', 'slug' => 'mechanical-engineer',],
        ['name' => 'eletric engineer', 'slug' => 'eletric-engineer',],
        ['name' => 'civil engineer', 'slug' => 'civil-engineer',],
    ];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach (self::BASE_SPECIALTIES as $unity) {
            Specialty::firstOrCreate($unity, $unity);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('specialties')->truncate();
    }
};
