<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            if (!Schema::hasColumn('usuario', 'password')) {
                $table->string('password')->nullable()->after('email');
            }
            if (!Schema::hasColumn('usuario', 'remember_token')) {
                $table->rememberToken()->after('tipo');
            }
        });
    }

    public function down(): void
    {
        Schema::table('usuario', function (Blueprint $table) {
            if (Schema::hasColumn('usuario', 'password')) {
                $table->dropColumn('password');
            }
            if (Schema::hasColumn('usuario', 'remember_token')) {
                $table->dropColumn('remember_token');
            }
        });
    }
};
