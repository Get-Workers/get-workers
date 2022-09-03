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

    public function withWorker()
    {
        return $this->state(function (array $attributes) {
            $worker = Worker::factory()->withUser()->create();
            return [
                'worker_id' => $worker->id,
            ];
        });
    }

    public function withUnity()
    {
        return $this->state(function (array $attributes) {
            $unity = Unity::inRandomOrder()->first();
            return [
                'unity_id' => $unity->id,
            ];
        });
    }

    public function withTime()
    {
        return $this->state(function (array $attributes) {
            $hours = random_int(0, 23);
            $minutes = random_int(0, 59);
            return [
                'time' => now()->hour($hours)->minute($minutes)->second(0)->format('H:i:s'),
            ];
        });
    }

    public function withPrice()
    {
        return $this->state(function (array $attributes) {
            return [
                'price' => random_int(0, 999999),
            ];
        });
    }
}
