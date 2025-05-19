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
        // Elimina el procedimiento si ya existe, para evitar errores
        DB::unprepared("DROP PROCEDURE IF EXISTS ConsultarMateriasPrimasPorProduccion");

        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarMateriasPrimasPorProduccion`(IN `produccion_id` INT)
        BEGIN
            SELECT mp.mat_pri_nombre, SUM(mp.mat_pri_cantidad) AS total_usado
            FROM produccion AS p
            JOIN produccion_materias_primas AS pmp ON p.id_produccion = pmp.produccion_id
            JOIN materia_prima AS mp ON pmp.materia_prima_id = mp.id_materia_prima
            WHERE p.id_produccion = produccion_id
            GROUP BY mp.mat_pri_nombre;
        END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS ConsultarMateriasPrimasPorProduccion");
    }
};
