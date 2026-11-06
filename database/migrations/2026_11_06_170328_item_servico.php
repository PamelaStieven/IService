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
        Schema::create('itemservico', function (Blueprint $table) {
            $table->id('ItemServicoID');
            $table->foreignId('AgendamentoID')->constrained('agendamento', 'AgendamentoID')->onDelete('cascade');
            $table->foreignId('ServicoID')->constrained('servico', 'ServicoID')->onDelete('cascade');
            $table->text('descricao_item');
            $table->date('data_item');
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
