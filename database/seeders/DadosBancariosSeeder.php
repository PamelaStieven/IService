<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DadosBancarios;

class DadosBancariosSeeder extends Seeder
{
    
    public function run(): void
    {
        DadosBancarios::factory()->count(10)->create();
    }
}
