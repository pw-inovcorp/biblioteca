<?php

namespace Database\Factories;
use App\Models\Autor;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Autor>
 */
class AutorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Autor::class;
    public function definition(): array
    {
        return [
            //
            'name' => $this->faker->name(),
            'foto' => 'https://picsum.photos/640/480?random=' . rand(1, 1000)
        ];
    }
}
