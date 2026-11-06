<?php

namespace Database\Factories;

use App\Models\DadosBancarios;
use App\Models\Tecnicos;
use Illuminate\Database\Eloquent\Factories\Factory;

class DadosBancariosFactory extends Factory
{
    protected $model = DadosBancarios::class;

    public function definition(): array
    {
        return [
            'TecnicoID'        => Tecnicos::factory(),
            'banco'            => $this->faker->randomElement(['Banco do Brasil', 'Itaú', 'Bradesco', 'Santander', 'Nubank']),
            'agencia'          => $this->faker->numerify('####'),
            'numero_conta'     => $this->faker->numerify('#####-#'),
            'tipo_conta'       => $this->faker->numberBetween(1, 2),
            'titular'          => $this->faker->name(),
            'cpf_cnpj_titular' => $this->faker->numerify('###.###.###-##'),
        ];
    }
}