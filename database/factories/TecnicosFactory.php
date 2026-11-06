<?php

namespace Database\Factories;

use App\Models\Tecnico;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class TecnicosFactory extends Factory
{
    protected $model = Tecnico::class;

    public function definition(): array
    {
        return [
            'UserID' => Usuario::factory()->state([
                'tipo' => 'Técnico',
            ]),
            'documento' => $this->faker->bothify('DOC-#####'),
        ];
    }
}