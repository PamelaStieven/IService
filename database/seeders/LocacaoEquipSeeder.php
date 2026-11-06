<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LocacaoEquip;

class LocacaoEquipSeeder extends Seeder
{
    
    public function run(): void
    {
        LocacaoEquip::factory()->count(10)->create();
    }
}
