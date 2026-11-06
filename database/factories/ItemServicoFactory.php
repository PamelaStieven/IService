<?php

namespace Database\Factories;

use App\Models\ItemServico;
use App\Models\Agendamento;
use App\Models\Servico;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemServicoFactory extends Factory
{
    protected $model = ItemServico::class;

    public function definition(): array
    {
        return [
            'AgendamentoID'  => Agendamento::factory(),
            'ServicoID'      => Servico::factory(),
            'descricao_item' => $this->faker->sentence(),
            'data_item'      => $this->faker->date(),
        ];
    }
}