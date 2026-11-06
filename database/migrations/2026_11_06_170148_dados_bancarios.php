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
        Schema::create('dados_bancarios', function (Blueprint $table) {
            $table->id('ContaID');
            $table->foreignId('TecnicoID')->constrained('tecnicos', 'TecnicoID')->onDelete('cascade');
            $table->string('banco', 55);
            $table->string('agencia', 6);
            $table->string('numero_conta', 16);
            $table->tinyInteger('tipo_conta');
            $table->string('titular', 55);
            $table->string('cpf_cnpj_titular', 18);
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
        //
    }
};
