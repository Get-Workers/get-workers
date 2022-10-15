<?php

namespace Database\Factories;

use App\Models\Unity;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Work>
 */
class WorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->name();
        return [
            'name' => $name,
            'slug' => Str::slug($name),
        ];
    }

    /**
     * @return static
     */
    public function withWorker(): static
    {
        return $this->state(function () {
            $worker = Worker::factory()->withUser()->create();
            return [
                'worker_id' => $worker->id,
            ];
        });
    }

    /**
     * @return static
     */
    public function withUnity(): static
    {
        return $this->state(function () {
            $unity = Unity::inRandomOrder()->first();
            return [
                'unity_id' => $unity->id,
            ];
        });
    }

    /**
     * @return static
     */
    public function withTime(): static
    {
        return $this->state(function () {
            $hours = random_int(0, 23);
            $minutes = random_int(0, 59);
            return [
                'time' => now()->hour($hours)->minute($minutes)->second(0)->format('H:i:s'),
            ];
        });
    }

    /**
     * @return static
     */
    public function withPrice(): static
    {
        return $this->state(function () {
            return [
                'price' => random_int(0, 999999),
            ];
        });
    }

    /**
     * @return static
     */
    public function withDescription(): static
    {
        return $this->state(function () {
            $hasDescription = (bool) random_int(0, 1);
            $description = ($hasDescription) ? $this->faker->text(rand(100, 512)) : null;
            return [
                'description' => $description,
            ];
        });
    }
}
