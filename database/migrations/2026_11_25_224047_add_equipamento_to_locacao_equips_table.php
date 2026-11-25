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
        Schema::table('locacao_equips', function (Blueprint $table) {
            $table->foreignId('EquipID')
                ->nullable()
                ->after('UserID')
                ->constrained('equipamentos', 'EquipID')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('locacao_equips', function (Blueprint $table) {
            $table->dropForeign(['EquipID']);
            $table->dropColumn('EquipID');
        });
    }
};
