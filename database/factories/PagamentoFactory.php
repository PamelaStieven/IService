<?php

namespace Database\Factories;

use App\Models\Pagamento;
use App\Models\Agendamento;
use App\Models\LocacaoEquip;
use Illuminate\Database\Eloquent\Factories\Factory;

class PagamentoFactory extends Factory
{
    protected $model = Pagamento::class;

    public function definition(): array
    {
        return [
            'AgendaID'         => Agendamento::factory(),
            'LocEquipID'       => LocacaoEquip::factory(),
            'metodo'           => $this->faker->randomElement(['PIX', 'Boleto']),
            'valor_total'      => $this->faker->randomFloat(2, 100, 1000),
            'taxa_site'        => $this->faker->randomFloat(1, 5, 20),
            'status_pagamento' => $this->faker->numberBetween(0, 1),
            'data_pagamento'   => $this->faker->dateTimeThisMonth(),
        ];
    }
}