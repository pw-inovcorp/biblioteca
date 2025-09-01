<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Livro>
 */
class LivroFactory extends Factory
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
            'isbn' => $this->faker->unique()->isbn13(),
            'name' => $this->faker->sentence(3),
            'editor_id' => \App\Models\Editor::factory(),
            'bibliography' => $this->faker->paragraph(),
            'image' => 'https://picsum.photos/640/480?random=' . rand(1, 1000),
            'price' => $this->faker->numberBetween(10, 151),
            'stock' => $this->faker->numberBetween(1, 50)
        ];
    }

    public function semStock()
    {
        return $this->state(['stock' => 0]);
    }

    public function comStock($quantidade)
    {
        return $this->state(['stock' => $quantidade]);
    }
}
