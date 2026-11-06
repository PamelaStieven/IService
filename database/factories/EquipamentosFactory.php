<?php

namespace Database\Factories;

use App\Models\Equipamentos;
use App\Models\Tecnicos;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipamentosFactory extends Factory
{
    protected $model = Equipamentos::class;

    public function definition(): array
    {
        return [
            'usuario_id' => App\Models\Usuario::factory(),
            'nome' => $this->faker->randomElement([
                'Furadeira',
                'Parafusadeira',
                'Serra elétrica',
                'Lixadeira',
                'Compressor',
                'Máquina de solda'
            ]),
            'modelo' => $this->faker->bothify('MOD-#####'),
            'descricao_tecnica' => $this->faker->sentence(),
            'data_compra' => $this->faker->dateTimeBetween(
                '-5 years',
                'now'
            ),
            'valor_aluguel' => $this->faker->randomFloat(2, 50, 1500),
            'status' => $this->faker->randomElement(['Disponível', 'Alugado', 'Em manutenção']),
        'status',
        ];
    }
}