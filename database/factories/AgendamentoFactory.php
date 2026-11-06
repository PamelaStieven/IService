<?php

namespace Database\Factories;

use App\Models\Agendamento;
use App\Models\Tecnicos;
use App\Models\Servico;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class AgendamentoFactory extends Factory
{
    protected $model = Agendamento::class;

    public function definition(): array
    {
        return [
            'TecnicoID'        => Tecnicos::factory(),
            'ServicoID'        => Servico::factory(),
            'UserID'           => Usuario::factory()->state(['tipo' => 'Usuário']),
            'data_hora_inicio' => $this->faker->dateTimeBetween('now', '+5 days'),
            'data_hora_fim'    => $this->faker->dateTimeBetween('+5 days', '+10 days'),
            'status_servico'   => $this->faker->randomElement(['Aceito', 'Pendente', 'Cancelado', 'Concluído']),
        ];
    }
}