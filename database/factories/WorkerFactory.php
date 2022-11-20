<?php

namespace Database\Factories;

use App\Models\PhoneNumber;
use App\Models\User;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Worker>
 */
class WorkerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'cnpj' => $this->generateCnpj(),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Worker $worker) {
            $this->createPhoneNumbers($worker);
        });
    }


    /**
     * Create a new user for each worker profile
     *
     * @return static
     */
    public function withUser(): static
    {
        return $this->state(function (array $attributes) {
            $user = User::factory()->create();
            return [
                'user_id' => $user->id,
            ];
        });
    }

    /**
     * @return string
     */
    private function generateCnpj(): string
    {
        $cnpj = '';
        for ($i = 0; $i < 14; $i++) {
            $cnpj .= random_int(0, 9);
        }
        return $cnpj;
    }

    /**
     * @param  Worker  $worker
     * @return void
     */
    private function createPhoneNumbers(Worker $worker): void
    {
        $phoneNumberQuantity = random_int(0, 3);
        if ($phoneNumberQuantity === 0) return;

        $phoneNumbers = PhoneNumber::factory($phoneNumberQuantity)->create();
        $phoneArray = $phoneNumbers->map(fn (PhoneNumber $phoneNumber) => $phoneNumber->id);

        $worker->phoneNUmbers()->sync($phoneArray);
    }
}
