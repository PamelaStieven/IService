<?php

namespace Database\Factories;

use App\Models\LocacaoEquip;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class LocacaoEquipFactory extends Factory
{
    protected $model = LocacaoEquip::class;

    public function definition(): array
    {
        return [
            'UserID'        => Usuario::factory()->state(['tipo' => 'Usuário']),
            'data_retirada' => $this->faker->dateTimeBetween('-10 days', 'now'),
            'data_devolucao'=> $this->faker->dateTimeBetween('now', '+10 days'),
        ];
    }
}