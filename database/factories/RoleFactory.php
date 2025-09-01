<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'name' => $this->faker->randomElement(['admin', 'cidadao']),
            'description' => $this->faker->sentence(),
        ];
    }

    public function admin()
    {
        return $this->state(['name' => 'admin']);
    }

    public function cidadao()
    {
        return $this->state(['name' => 'cidadao']);
    }
}
