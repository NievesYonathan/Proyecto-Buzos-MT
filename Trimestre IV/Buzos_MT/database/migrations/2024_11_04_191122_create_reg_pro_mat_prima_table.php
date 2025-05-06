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
        Schema::create('reg_pro_mat_prima', function (Blueprint $table) {
            $table->integer('id_registro', true)->comment('Identificador unico de la tabla registro');
            $table->integer('reg_pmp_cantidad_usada')->comment('Atrubuto que identifica la cantidad de materia prima usada');
            $table->date('reg_pmp_fecha_registro')->comment('Atrubuto que identifica la la fecha de registro de la materia prima producida');
            $table->integer('id_pro_materia_prima')->index('fk_materiaprima_idx');
            $table->integer('id_produccion')->index('fk_produccion_idx');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reg_pro_mat_prima');
    }
};
