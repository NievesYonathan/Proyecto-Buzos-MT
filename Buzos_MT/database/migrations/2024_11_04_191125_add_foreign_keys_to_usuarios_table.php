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
        Schema::table('usuarios', function (Blueprint $table) {
            $table->foreign(['usu_estado'], 'fk_estados')->references(['id_estados'])->on('estados')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['t_doc'], 'fk_TipoDoc')->references(['id_tipo_documento'])->on('tipo_doc')->onUpdate('cascade')->onDelete('no action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('usuarios', function (Blueprint $table) {
            $table->dropForeign('fk_estados');
            $table->dropForeign('fk_TipoDoc');
        });
    }
};
