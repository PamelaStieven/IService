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
        Schema::create('equipamentos', function (Blueprint $table) {
            $table->id('EquipID');
            $table->foreignId('UserID')->constrained('users', 'UserID')->onDelete('cascade');
            $table->string('nome', 55);
            $table->string('modelo', 55);
            $table->text('descricao_tecnica');
            $table->dateTime('data_compra');
            $table->decimal('valor_aluguel', 12, 2);
            $table->enum('status', ['Alugado', 'Disponível']);
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
