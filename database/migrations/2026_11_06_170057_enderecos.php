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
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id('EnderecosID');
            $table->foreignID('userID')->constrained('users', 'UserID')->onDelete('cascade');;
            $table->string('apelido', 55);
            $table->string('rua', 55);
            $table->integer('numero');
            $table->string('bairro', 55);
            $table->string('cep', 11);
            $table->string('cidade', 55);
            $table->string('estado', 55);
            $table->string('pais', 55);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
