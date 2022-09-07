<?php

namespace Database\Seeders;

use App\Models\Specialty;
use App\Models\Work;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialtyWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $works = Work::all();
        $specialties = Specialty::all();
        $specialtiesCount = $specialties->count();

        $works->each(function (Work $work) use (&$specialties, &$specialtiesCount) {
            $hasSpecialty = (bool) random_int(0, 1);
            if (! $hasSpecialty) {
                return;
            }
            $specialties->shuffle();

            $randomQuantity = random_int(1, $specialtiesCount);
            $selectedSpecialties = $specialties->take($randomQuantity);
            $work->specialties()->saveMany($selectedSpecialties);
        });
    }
}
