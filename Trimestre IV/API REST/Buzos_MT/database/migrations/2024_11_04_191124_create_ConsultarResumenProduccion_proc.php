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
        // Asegura que el procedimiento no exista antes de crearlo
        DB::unprepared("DROP PROCEDURE IF EXISTS ConsultarResumenProduccion");

        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarResumenProduccion`()
        BEGIN
            SELECT p.pro_nombre, p.pro_cantidad, p.pro_fecha_inicio, p.pro_fecha_fin, e.eta_nombre AS estado
            FROM produccion AS p
            JOIN etapas AS e ON p.pro_etapa = e.id_etapas;
        END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS ConsultarResumenProduccion");
    }
};
