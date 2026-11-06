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
        Schema::create('agendamento', function (Blueprint $table) {
            $table->id('AgendamentoID');
            $table->foreignId('TecnicoID')->constrained('tecnicos', 'TecnicoID')->onDelete('cascade');
            $table->foreignId('ServicoID')->constrained('servico', 'ServicoID')->onDelete('cascade');
            $table->foreignId('UserID')->constrained('usuario', 'UserID')->onDelete('cascade');
            $table->dateTime('data_hora_inicio');
            $table->dateTime('data_hora_fim');
            $table->enum('status_servico', ['Aceito', 'Pendente', 'Cancelado', 'Concluido']);
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
