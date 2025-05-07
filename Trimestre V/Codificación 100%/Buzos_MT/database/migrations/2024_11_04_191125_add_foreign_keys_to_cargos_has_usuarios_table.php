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
        Schema::table('cargos_has_usuarios', function (Blueprint $table) {
            $table->foreign(['cargos_id_cargos'], 'fk_cargos_has_usuarios_cargos1')->references(['id_cargos'])->on('cargos')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['usuarios_num_doc'], 'fk_cargos_has_usuarios_usuarios1')->references(['num_doc'])->on('usuarios')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign(['estado_asignacion'], 'fk_estadoCU')->references(['id_estados'])->on('estados')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cargos_has_usuarios', function (Blueprint $table) {
            $table->dropForeign('fk_cargos_has_usuarios_cargos1');
            $table->dropForeign('fk_cargos_has_usuarios_usuarios1');
            $table->dropForeign('fk_estadoCU');
        });
    }
};
