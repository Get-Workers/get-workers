<?php

namespace Database\Seeders;

use App\Models\HiredWork;
use App\Models\Review;
use App\Models\ReviewHiredWorkContractor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewHiredWorkContractorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hiredWorks = HiredWork::factory(10)->withWork()->withContractor()->create([
            'initiated_at' => now(),
            'done_at' => now(),
        ]);

        $hiredWorks->each(function (HiredWork $hiredWork) {
            $newReview = Review::factory()->create();

            $newReviewHiredWorkContractor = new ReviewHiredWorkContractor();
            $newReviewHiredWorkContractor->review()
                ->associate($newReview);
            $newReviewHiredWorkContractor->hiredWork()
                ->associate($hiredWork);

            $newReviewHiredWorkContractor->save();
        });
    }
}
