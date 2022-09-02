<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Contractor>
 */
class ContractorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
        ];
    }

    /**
     * Create a new user for each contractor profile
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
}
