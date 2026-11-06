<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tecnicos;

class TecnicosSeeder extends Seeder
{
    
    public function run(): void
    {
        Tecnicos::factory()->count(10)->create();
    }
}
