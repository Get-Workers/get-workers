<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            UserSeeder::class,
            WorkerSeeder::class,
            ContractorSeeder::class,
            WorkSeeder::class,
            HiredWorkSeeder::class,
            CertificationSeeder::class,
            SpecialtyWorkerSeeder::class,
            SpecialtyWorkSeeder::class,
        ]);
    }
}
