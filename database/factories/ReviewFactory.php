<?php

namespace Database\Factories;

use App\Models\Contractor;
use App\Models\HiredWork;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $hiredWork = HiredWork::factory()
            ->withWork()
            ->withContractor()
            ->create();
        return [
            'hired_work_id' => $hiredWork->id,
            'title' => $this->faker->title(),
            'description' => $this->faker->text(),
            'rating' => random_int(0, 5),
        ];
    }

    /**
     * @return static
     */
    public function fromContractor(): static
    {
        return $this->state(function (array $attributes) {
            $contractor = HiredWork::find($attributes['hired_work_id'])
                ->contractor;

            return [
                'contractor_id' => $contractor,
            ];
        });
    }

    /**
     * @return static
     */
    public function fromWorker(): static
    {
        return $this->state(function (array $attributes) {
            $worker = HiredWork::find($attributes['hired_work_id'])
                ->work
                ->worker;

            return [
                'worker_id' => $worker,
            ];
        });
    }
}
