<?php

namespace Database\Factories;

use App\Models\User;
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
     * @return string
     */
    private function generateCnpj(): string
    {
        $cnpj = '';
        for ($i = 0; $i < 14; $i++) {
            $cnpj .= $this->faker->rand(0, 9);
        }
        return $cnpj;
    }
}
