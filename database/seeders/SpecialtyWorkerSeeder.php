<?php

namespace Database\Seeders;

use App\Models\Specialty;
use App\Models\SpecialtyWorker;
use App\Models\Worker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpecialtyWorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $workers = Worker::all();
        $specialties = Specialty::all();
        $specialtiesCount = $specialties->count();

        $workers->each(function (Worker $worker) use (&$specialties, &$specialtiesCount) {
            $hasSpecialty = (bool) random_int(0, 1);
            if (! $hasSpecialty) {
                return;
            }
            $specialties->shuffle();

            $randomQuantity = random_int(1, $specialtiesCount);
            $selectedSpecialties = $specialties->take($randomQuantity);
            $worker->specialties()->saveMany($selectedSpecialties);
        });
    }
}
