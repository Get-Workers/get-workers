<?php

namespace Database\Seeders;

use App\Models\PhoneNumberWorker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PhoneNumberWorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PhoneNumberWorker::factory(10)->create();
    }
}
