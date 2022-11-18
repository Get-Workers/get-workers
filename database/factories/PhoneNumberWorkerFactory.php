<?php

namespace Database\Factories;

use App\Models\PhoneNumber;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PhoneNumberWorker>
 */
class PhoneNumberWorkerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $phoneNumber = PhoneNumber::factory()->create();
        $worker = Worker::factory()->withUser()->create();
        $validated = (bool) random_int(0, 1);

        return [
            'phone_number_id' => $phoneNumber,
            'worker_id' => $worker,
            'validated_at' => $validated ? now() : null,
        ];
    }
}
