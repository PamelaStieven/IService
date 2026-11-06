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
            'cpf_cnpj'        => $this->faker->numerify('###.###.###-##'),
            'data_nascimento' => $this->faker->dateTimeBetween('-60 years', '-18 years'),
            'telefone'        => $this->faker->numerify('(##)9####-####'),
            'tipo'            => $this->faker->randomElement(['Técnico', 'Administrador', 'Usuário']),
        ];
    }
}