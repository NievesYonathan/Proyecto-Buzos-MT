<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('seguridad', function (Blueprint $table) {
            $table->foreign(['usu_num_doc'], 'fk_seguridad_usuarios1')->references(['num_doc'])->on('usuarios')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('seguridad', function (Blueprint $table) {
            $table->dropForeign('fk_seguridad_usuarios1');
        });
    }
};
