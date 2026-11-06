<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id('UserID');
<<<<<<< HEAD
            $table->string('nome_razao', 35);
=======
            $table->string('nome_razao', 55);
>>>>>>> 63036773d8fadb38c54a27b4193dbee5dc660f5a
            $table->string('email', 55)->unique();
            $table->string('cpf_cnpj', 18)->unique();
            $table->dateTime('data_nascimento');
            $table->string('telefone', 14);
            $table->enum('tipo', ['Técnico', 'Administrador', 'Usuário']);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuario');
    }
};
