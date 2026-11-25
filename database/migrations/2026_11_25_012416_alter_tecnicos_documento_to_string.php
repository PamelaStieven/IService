<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tecnicos', function (Blueprint $table) {
            // Troca binary (blob) por string para armazenar o caminho do arquivo
            $table->string('documento', 255)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('tecnicos', function (Blueprint $table) {
            $table->binary('documento')->nullable()->change();
        });
    }
};
