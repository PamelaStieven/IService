<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::updateOrCreate(
            ['email' => 'admin@iservice.com'],
            [
                'nome_razao'      => 'Administrador IService',
                'password'        => Hash::make('admin123'),
                'cpf_cnpj'        => '000.000.000-00',
                'data_nascimento' => '1990-01-01 00:00:00',
                'telefone'        => '(11)99999-9999',
                'tipo'            => 'Administrador',
            ]
        );
    }
}
