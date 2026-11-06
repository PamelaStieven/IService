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
        Schema::create('servicos', function (Blueprint $table) {
            $table->id('ServicoID');
            $table->foreignId('TecnicoID')->constrained('tecnicos', 'TecnicoID')->onDelete('cascade');
            $table->string('titulo', 55);
            $table->string('categoria', 55);
            $table->text('descricao');
            $table->decimal('preco_base', 12, 2);
            $table->enum('tipo_preco', ['Hora', 'Por Serviço']);
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
