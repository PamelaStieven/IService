<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Habilidade;

class HabilidadeSeeder extends Seeder
{
    
    public function run(): void
    {
        Habilidade::factory()->count(10)->create();
    }
}
