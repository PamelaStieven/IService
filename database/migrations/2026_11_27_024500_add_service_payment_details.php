<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('agendamento', function (Blueprint $table) {
            $table->string('metodo_pagamento', 20)->nullable();
        });

        Schema::table('pagamentos', function (Blueprint $table) {
            $table->decimal('comissao_empresa', 12, 2)->nullable();
        });
    }

    public function down()
    {
        Schema::table('pagamentos', function (Blueprint $table) {
            $table->dropColumn('comissao_empresa');
        });

        Schema::table('agendamento', function (Blueprint $table) {
            $table->dropColumn('metodo_pagamento');
        });
    }
};
