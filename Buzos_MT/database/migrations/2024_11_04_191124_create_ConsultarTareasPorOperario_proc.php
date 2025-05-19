<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */

     
    public function up(): void
    {
             DB::unprepared("DROP PROCEDURE IF EXISTS ConsultarTareasPorOperario");

        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarTareasPorOperario`(IN `usuario_num_doc` INT)
BEGIN
    SELECT t.tar_nombre, et.emp_tar_fecha_asignacion, et.emp_tar_fecha_entrega
    FROM emp_tarea AS et
    JOIN tarea AS t ON et.tarea_id_tarea = t.id_tarea
    WHERE et.id_empleado_tarea = usuario_num_doc;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS ConsultarTareasPorOperario");
    }
};
