<?php

namespace Database\Factories;

use App\Models\Contractor;
use App\Models\Work;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContractedWork>
 */
class ContractedWorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [];
    }

    /**
     * @return static
     */
    public function withWork(): static
    {
        return $this->state(function (array $attributes) {
            $work = Work::factory()->withWorker()->create();
            return [
                'work_id' => $work->id,
            ];
        });
    }

    /**
     * @return static
     */
    public function withContractor(): static
    {
        return $this->state(function (array $attributes) {
            $contractor = Contractor::factory()->withUser()->create();
            return [
                'contractor_id' => $contractor->id,
            ];
        });
    }

    /**
     * @return static
     */
    public function withPrice(): static
    {
        return $this->state(function (array $attributes) {
            $hasPrice = (bool) random_int(0, 1);
            return [
                'price' => ($hasPrice) ? random_int(100, 999999) : null,
            ];
        });
    }

    /**
     * @return static
     */
    public function isPaid(): static
    {
        return $this->state(function (array $attributes) {
            $hasValuePaid = (((bool) random_int(0, 1)) && (! is_null($attributes['price'])));
            return [
                'value_paid' => ($hasValuePaid) ? random_int($attributes['price'], 999999) : null,
            ];
        });
    }

    /**
     * @return static
     */
    public function initiated(): static
    {
        return $this->state(function (array $attributes) {
            $timestamp = now();

            $hasInitiated = (bool) random_int(0, 1);
            if ($hasInitiated) {
                $timestamp->subHours(random_int(0, 12));
                $timestamp->subMinutes(random_int(0, 60));
                $timestamp->subSeconds(random_int(0, 60));
            }

            return [
                'initiated_at' => ($hasInitiated) ? $timestamp : null,
            ];
        });
    }

    /**
     * @return static
     */
    public function done(): static
    {
        return $this->state(function (array $attributes) {
            $timestamp = now();

            $hasDone = (((bool) random_int(0, 1)) && (! is_null($attributes['initiated_at'])));
            if ($hasDone) {
                $timestamp->addHours(random_int(0, 12));
                $timestamp->addMinutes(random_int(0, 60));
                $timestamp->addSeconds(random_int(0, 60));
            }

            return [
                'done_at' => ($hasDone) ? $timestamp : null,
            ];
        });
    }
}
