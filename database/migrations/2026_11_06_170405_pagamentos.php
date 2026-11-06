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
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id('PagamentoID');
            $table->foreignId('AgendamentoID')->nullable()->constrained('agendamentos', 'AgendamentoID')->onDelete('cascade');
            $table->foreignId('LocEquipID')->nullable()->constrained('locacao_equips', 'LocEquipID')->onDelete('cascade');
            $table->enum('metodo', ['PIX', 'Boleto']);
            $table->decimal('valor_total', 12, 2);
            $table->decimal('taxa_site', 12, 1);
            $table->boolean('status_pagamento');
            $table->dateTime('data_pagamento');
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
