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
        Schema::create('emp_tarea', function (Blueprint $table) {
            $table->integer('id_empleado_tarea', true)->comment('Identificador unico de la tabla puente Emp Tarea
 ');
            $table->integer('empleados_num_doc')->index('fk_doc_empleado_idx')->comment('Fk que esintermediario entre empleado y numero de documento');
            $table->integer('tarea_id_tarea')->index('fk_empleados_has_tarea_tarea1_idx')->comment('Fk que es intermediario entre tare y Id de la tarea');
            $table->date('emp_tar_fecha_asignacion')->comment('Atributo que identifica la fecha de asignacion ');
            $table->date('emp_tar_fecha_entrega')->comment('Atributo que identifica la fecha de entrega');
            $table->integer('emp_tar_estado_tarea')->index('emp_tar_estado_tarea')->comment('Atributo que identifica el estado de la tarea');
            $table->integer('produccion_id_produccion')->index('fk_emp_tarea_produccion1_idx')->comment('fk que comunica com la tabla producción');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emp_tarea');
    }
};
