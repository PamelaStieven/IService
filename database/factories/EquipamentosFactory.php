<?php

namespace Database\Factories;

use App\Models\Usuario;
use App\Models\Equipamentos;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipamentosFactory extends Factory
{
    protected $model = Equipamentos::class;

    public function definition(): array
    {
        $valorDiaria = $this->faker->randomFloat(2, 50, 1500);

        return [
            'UserID' => Usuario::factory(),
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
            'estado_conservacao' => $this->faker->randomElement(['Pessimo', 'Bom', 'Muito Bom']),
            'valor_diaria' => $valorDiaria,
            'data_compra' => $this->faker->dateTimeBetween(
                '-5 years',
                'now'
            ),
            'valor_aluguel' => $valorDiaria,
            'status' => $this->faker->randomElement(['Disponível', 'Alugado']),
        ];
    }
}