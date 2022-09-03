<?php

namespace Database\Seeders;

use App\Models\Work;
use App\Models\Worker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // With new workers
        Work::factory(5)
            ->withWorker()
            ->create();

        Worker::all()->each(function (Worker $worker) {
            $hasUnity = (bool) random_int(0, 1);
            $hasTime = (bool) random_int(0, 1);
            $hasPrice = (bool) random_int(0, 1);
            $isTrashed = (bool) random_int(0, 1);
            $worksQuantity = random_int(1, 10);



            $worksFactory = Work::factory($worksQuantity);
            if ($hasUnity) {
                $worksFactory = $worksFactory->withUnity();
            }

            if ($hasTime) {
                $worksFactory = $worksFactory->withTime();
            }

            if ($hasPrice) {
                $worksFactory = $worksFactory->withPrice();
            }

            if ($isTrashed) {
                $worksFactory = $worksFactory->trashed();
            }

            $worker->works()->createMany(
                $worksFactory->make()->toArray()
            );
        });
    }
}
