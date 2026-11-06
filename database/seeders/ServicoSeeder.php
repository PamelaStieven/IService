<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Servico;

class ServicoSeeder extends Seeder
{
    
    public function run(): void
    {
        Servico::factory()->count(10)->create();
    }
}
