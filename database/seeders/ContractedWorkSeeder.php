<?php

namespace Database\Seeders;

use App\Models\ContractedWork;
use App\Models\Contractor;
use App\Models\Work;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class ContractedWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contractors = Contractor::all();
        $works = Work::all();

        $this->addSimple($works, $contractors);
        $this->addWithPrice($works, $contractors);
        $this->addInitialized($works, $contractors);
        $this->addInitializedWithPrice($works, $contractors);
        $this->addInitializedAndDone($works, $contractors);
        $this->addInitializedAndDoneWithPrice($works, $contractors);
        $this->addInitializedAndDoneWithPriceAndisPaid($works, $contractors);
    }

    /**
     * @param  Collection  $works
     * @param  Collection  $contractors
     * @return void
     */
    private function addSimple(Collection &$works, Collection &$contractors): void
    {
        ContractedWork::factory(20)->make()
            ->each(function (ContractedWork $contractedWork) use (&$works, &$contractors) {
                $work = $this->getRandomModel($works);
                $contractedWork->work()->associate($work);

                $contractor = $this->getRandomModel($contractors);
                $contractedWork->contractor()->associate($contractor);

                $contractedWork->save();
            });
    }

    /**
     * @param  Collection  $works
     * @param  Collection  $contractors
     * @return void
     */
    private function addWithPrice(Collection &$works, Collection &$contractors): void
    {
        ContractedWork::factory(20)->withPrice()->make()
            ->each(function (ContractedWork $contractedWork) use (&$works, &$contractors) {
                $work = $this->getRandomModel($works);
                $contractedWork->work()->associate($work);

                $contractor = $this->getRandomModel($contractors);
                $contractedWork->contractor()->associate($contractor);

                $contractedWork->save();
            });
    }

    /**
     * @param  Collection  $works
     * @param  Collection  $contractors
     * @return void
     */
    private function addInitialized(Collection &$works, Collection &$contractors): void
    {
        ContractedWork::factory(20)->initiated()->make()
            ->each(function (ContractedWork $contractedWork) use (&$works, &$contractors) {
                $work = $this->getRandomModel($works);
                $contractedWork->work()->associate($work);

                $contractor = $this->getRandomModel($contractors);
                $contractedWork->contractor()->associate($contractor);

                $contractedWork->save();
            });
    }

    /**
     * @param  Collection  $works
     * @param  Collection  $contractors
     * @return void
     */
    private function addInitializedWithPrice(Collection &$works, Collection &$contractors): void
    {
        ContractedWork::factory(20)->withPrice()->initiated()->make()
            ->each(function (ContractedWork $contractedWork) use (&$works, &$contractors) {
                $work = $this->getRandomModel($works);
                $contractedWork->work()->associate($work);

                $contractor = $this->getRandomModel($contractors);
                $contractedWork->contractor()->associate($contractor);

                $contractedWork->save();
            });
    }

    /**
     * @param  Collection  $works
     * @param  Collection  $contractors
     * @return void
     */
    private function addInitializedAndDone(Collection &$works, Collection &$contractors): void
    {
        ContractedWork::factory(20)->initiated()->done()->make()
            ->each(function (ContractedWork $contractedWork) use (&$works, &$contractors) {
                $work = $this->getRandomModel($works);
                $contractedWork->work()->associate($work);

                $contractor = $this->getRandomModel($contractors);
                $contractedWork->contractor()->associate($contractor);

                $contractedWork->save();
            });
    }

    /**
     * @param  Collection  $works
     * @param  Collection  $contractors
     * @return void
     */
    private function addInitializedAndDoneWithPrice(Collection &$works, Collection &$contractors): void
    {
        ContractedWork::factory(20)->withPrice()->initiated()->done()->make()
            ->each(function (ContractedWork $contractedWork) use (&$works, &$contractors) {
                $work = $this->getRandomModel($works);
                $contractedWork->work()->associate($work);

                $contractor = $this->getRandomModel($contractors);
                $contractedWork->contractor()->associate($contractor);

                $contractedWork->save();
            });
    }

    /**
     * @param  Collection  $works
     * @param  Collection  $contractors
     * @return void
     */
    private function addInitializedAndDoneWithPriceAndisPaid(Collection &$works, Collection &$contractors): void
    {
        ContractedWork::factory(20)->withPrice()->initiated()->done()->isPaid()->make()
            ->each(function (ContractedWork $contractedWork) use (&$works, &$contractors) {
                $work = $this->getRandomModel($works);
                $contractedWork->work()->associate($work);

                $contractor = $this->getRandomModel($contractors);
                $contractedWork->contractor()->associate($contractor);

                $contractedWork->save();
            });
    }

    /**
     * @param  Collection  $collections
     * @return Model
     */
    private function getRandomModel(Collection $collections)
    {
        return $collections->shuffle()->first();
    }
}
