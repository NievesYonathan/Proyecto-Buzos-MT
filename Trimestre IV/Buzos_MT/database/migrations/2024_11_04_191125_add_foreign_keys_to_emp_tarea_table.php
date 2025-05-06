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
        Schema::table('emp_tarea', function (Blueprint $table) {
            $table->foreign(['empleados_num_doc'], 'fk_doc_empleado')->references(['num_doc'])->on('usuarios')->onUpdate('cascade')->onDelete('no action');
            $table->foreign(['tarea_id_tarea'], 'fk_Empleados_has_Tarea_Tarea1')->references(['id_tarea'])->on('tarea')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['produccion_id_produccion'], 'fk_emp_tarea_produccion1')->references(['id_produccion'])->on('produccion')->onUpdate('no action')->onDelete('no action');
            $table->foreign(['emp_tar_estado_tarea'], 'fk_estadoTarea')->references(['id_estados'])->on('estados')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('emp_tarea', function (Blueprint $table) {
            $table->dropForeign('fk_doc_empleado');
            $table->dropForeign('fk_Empleados_has_Tarea_Tarea1');
            $table->dropForeign('fk_emp_tarea_produccion1');
            $table->dropForeign('fk_estadoTarea');
        });
    }
};
