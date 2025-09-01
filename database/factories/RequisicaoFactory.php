<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Requisicao;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Livro;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Requisicao>
 */
class RequisicaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $dataRequisicao = $this->faker->dateTimeBetween('-30 days', 'now');
        $dataPrevistaEntrega = Carbon::parse($dataRequisicao)->addDays(5);

        return [
            'numero_requisicao' => 'REQ-' . $this->faker->unique()->numberBetween(1000, 9999),
            'user_id' => User::factory(),
            'livro_id' => Livro::factory(),
            'data_requisicao' => $dataRequisicao,
            'data_prevista_entrega' => $dataPrevistaEntrega,
            'data_real_entrega' => null,
            'status' => 'ativa',
            'dias_decorridos' => null,
            'foto_cidadao' => null,
        ];
    }

    public function devolvida()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'devolvida',
                'data_real_entrega' => $this->faker->dateTimeBetween($attributes['data_requisicao'], 'now'),
                'dias_decorridos' => Carbon::parse($attributes['data_requisicao'])
                    ->diffInDays($this->faker->dateTimeBetween($attributes['data_requisicao'], 'now'))
            ];
        });
    }

}
