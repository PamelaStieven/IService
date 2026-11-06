<?php

namespace Database\Factories;

use App\Models\Enderecos;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnderecosFactory extends Factory
{php artisan migrate
    protected $model = Enderecos::class;

    public function definition(): array
    {
        return [
            'usuario_id' => Usuario::factory(),
            'apelido' => $this->faker->randomElement(['Casa', 'Trabalho', 'Apartamento']),
            'rua' => $this->faker->streetName(),
            'numero' => $this->faker->buildingNumber(),
            'bairro' => $this->faker->citySuffix(),
            'cep' => $this->faker->postcode(),
            'cidade' => $this->faker->city(),
            'estado' => $this->faker->state(),
            'pais' => 'Brasil',
        ];
    }
}
