<?php

namespace Database\Factories;

use App\Models\Tecnicos;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class TecnicosFactory extends Factory
{
    protected $model = Tecnicos::class;

    public function definition(): array
    {
        return [
            'UserID' => Usuario::factory(),
            'documento' => $this->faker->numerify('###########'),
        ];
    }
}