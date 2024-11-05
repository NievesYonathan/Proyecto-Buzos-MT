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
        Schema::create('cargos_has_usuarios', function (Blueprint $table) {
            $table->integer('id_usuario_cargo', true);
            $table->integer('cargos_id_cargos')->index('fk_cargos_has_usuarios_cargos1_idx');
            $table->integer('usuarios_num_doc')->index('fk_cargos_has_usuarios_usuarios1_idx');
            $table->dateTime('fecha_asignacion');
            $table->integer('estado_asignacion')->index('fk_estado_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cargos_has_usuarios');
    }
};
