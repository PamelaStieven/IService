<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class usuarioSeeder extends Seeder
{
    
    public function run(): void
    {
        Usuario::factory()->count(10)->create();
    }
}
