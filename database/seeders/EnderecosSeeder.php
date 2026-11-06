<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enderecos;

class EnderecosSeeder extends Seeder
{
    
    public function run(): void
    {
        Enderecos::factory()->count(10)->create();
    }
}
