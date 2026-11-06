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
                Schema::create('tecnicos', function (Blueprint $table) {
                    $table->id('TecnicoID');
                    $table->foreignId('UserID')->constrained('usuario', 'UserID')->onDelete('cascade');
                    $table->binary('documento')->nullable();
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
