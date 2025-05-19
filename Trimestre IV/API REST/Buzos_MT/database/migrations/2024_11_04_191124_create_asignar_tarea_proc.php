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
         DB::unprepared("DROP PROCEDURE IF EXISTS asignar_tarea");

        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `asignar_tarea`(IN `p_id_tarea` INT, IN `p_id_empleado` INT)
BEGIN
    -- Asignar tarea a empleado
    INSERT INTO emp_tarea(id_empleado, id_tarea, fecha_asignacion)
    VALUES (p_id_empleado, p_id_tarea, NOW());
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS asignar_tarea");
    }
};
