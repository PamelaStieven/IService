<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id('UserID');
            $table->string('nome', 35);
            $table->string('email', 55)->unique();
            $table->string('cpf_cnpj', 18)->unique();
            $table->dateTime('data_nascimento');
            $table->string('telefone', 14)->unique();
            $table->string('tipo', ['Técnico', 'Administrador', 'Usuário']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
