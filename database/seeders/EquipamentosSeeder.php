<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Equipamentos;
use App\Models\Usuario;

class EquipamentosSeeder extends Seeder
{
    public function run()
    {
        $usuarios = Usuario::all();

        if ($usuarios->isEmpty()) {
            $usuarios = collect([
                Usuario::factory()->create()
            ]);
        }

        Equipamentos::factory()->count(10)->create([
            'usuario_id' => $usuarios->random()->id,
        ]);
    }
}
