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
        Schema::create('locacao_equips', function (Blueprint $table) {
            $table->id('LocEquipID');
            $table->foreignId('UserID')->constrained('usuario', 'UserID')->onDelete('cascade');
            $table->dateTime('data_retirada');
            $table->dateTime('data_devolucao');
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
