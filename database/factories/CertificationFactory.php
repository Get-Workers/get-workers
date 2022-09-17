<?php

namespace Database\Factories;

use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Certification>
 */
class CertificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
        ];
    }

    /**
     * @return static
     */
    public function withWorker(): static
    {
        return $this->state(function (array $attributes) {
            $worker = Worker::factory()->withUser()->create();
            return [
                'worker_id' => $worker->id,
            ];
        });
    }

    /**
     * @return static
     */
    public function withDescription(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'description' => $this->faker->text(1024),
            ];
        });
    }

    /**
     * @return static
     */
    public function withCertifiedUuid(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'certified_uuid' => Str::uuid(),
            ];
        });
    }

    public function withCertifiedLink(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'certified_link' => $this->faker->url(),
            ];
        });
    }
}
