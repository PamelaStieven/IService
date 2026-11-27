<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('usuario', function (Blueprint $table) {
            $table->string('foto')->nullable();
        });

        Schema::table('equipamentos', function (Blueprint $table) {
            $table->string('estado_conservacao', 20)->default('Bom');
            $table->decimal('valor_diaria', 12, 2)->default(0);
            $table->string('imagem')->nullable();
        });

        DB::table('equipamentos')->update([
            'estado_conservacao' => 'Bom',
            'valor_diaria' => DB::raw('valor_aluguel'),
        ]);
    }

    public function down()
    {
        Schema::table('equipamentos', function (Blueprint $table) {
            $table->dropColumn(['estado_conservacao', 'valor_diaria', 'imagem']);
        });

        Schema::table('usuario', function (Blueprint $table) {
            $table->dropColumn('foto');
        });
    }
};
