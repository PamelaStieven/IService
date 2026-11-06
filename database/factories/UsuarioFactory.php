<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition(): array
    {
        return [
            'nome_razao'      => $this->faker->name(),
            'email'           => $this->faker->unique()->safeEmail(),
            'telefone'        => $this->faker->phoneNumber(),
            'tipo'            => $this->faker->randomElement(['cliente', 'funcionario']),
            'cpf_cnpj'        => $this->faker->numerify('###.###.###-##'),
            'data_nascimento' => $this->faker->date('Y-m-d', '-18 years'),
        ];
    }
}