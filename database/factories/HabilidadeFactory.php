<?php

namespace Database\Factories;

use App\Models\Habilidade;
use App\Models\Tecnicos;
use Illuminate\Database\Eloquent\Factories\Factory;

class HabilidadeFactory extends Factory
{
    protected $model = Habilidade::class;

    public function definition(): array
    {
        return [
            'TecnicoID' => Tecnicos::factory(),
            'descricao' => $this->faker->sentence(),
            'cursos'    => $this->faker->words(3, true),
        ];
    }
}