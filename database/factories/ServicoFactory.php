<?php

namespace Database\Factories;

use App\Models\Servico;
use App\Models\Tecnicos;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServicoFactory extends Factory
{
    protected $model = Servico::class;

    public function definition(): array
    {
        return [
            'TecnicoID'  => Tecnicos::factory(),
            'titulo'     => $this->faker->jobTitle(),
            'categoria'  => $this->faker->randomElement(['Manutenção', 'Instalação', 'Reparo']),
            'descricao'  => $this->faker->paragraph(),
            'preco_base' => $this->faker->randomFloat(2, 50, 500),
            'tipo_preco' => $this->faker->randomElement(['hora', 'Por Serviço']),
        ];
    }
}