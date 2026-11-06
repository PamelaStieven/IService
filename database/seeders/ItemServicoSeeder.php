<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ItemServico;

class ItemServicoSeeder extends Seeder
{
    
    public function run(): void
    {
        ItemServico::factory()->count(10)->create();
    }
}
