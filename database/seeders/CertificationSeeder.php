<?php

namespace Database\Seeders;

use App\Models\Certification;
use App\Models\Worker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CertificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Worker::all()->each(function (Worker $worker) {
            $this->createCertificationsForWorker($worker);
            $this->createCertificationsWithDescriptionForWorker($worker);
            $this->createCertificationsWithCertifiedUuidForWorker($worker);
            $this->createCertificationsTrashedForWorker($worker);
            $this->createCertificationsWithAllForWorker($worker);
        });
    }

    /**
     * @param  Worker  $worker
     * @return void
     */
    private function createCertificationsForWorker(Worker &$worker): void
    {
        Certification::factory(random_int(0, 10))->for($worker)->create();
    }

    /**
     * @param  Worker  $worker
     * @return void
     */
    private function createCertificationsWithDescriptionForWorker(Worker &$worker): void
    {
        Certification::factory(random_int(0, 10))->withDescription()->for($worker)->create();
    }

    /**
     * @param  Worker  $worker
     * @return void
     */
    private function createCertificationsWithCertifiedUuidForWorker(Worker &$worker): void
    {
        Certification::factory(random_int(0, 10))->withCertifiedUuid()->for($worker)->create();
    }

    /**
     * @param  Worker  $worker
     * @return void
     */
    private function createCertificationsTrashedForWorker(Worker &$worker): void
    {
        Certification::factory(random_int(0, 10))->trashed()->for($worker)->create();
    }

    /**
     * @param  Worker  $worker
     * @return void
     */
    private function createCertificationsWithAllForWorker(Worker &$worker): void
    {
        Certification::factory(random_int(0, 10))
            ->withDescription()
            ->withCertifiedUuid()
            ->trashed()
            ->for($worker)
            ->create();
    }
}
