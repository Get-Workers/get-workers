<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Worker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory(10)->create();
        $users->each(function (User $user) {
            $workerData = Worker::factory()->makeOne()->toArray();
            $user->worker()->create($workerData);
        });
    }
}
