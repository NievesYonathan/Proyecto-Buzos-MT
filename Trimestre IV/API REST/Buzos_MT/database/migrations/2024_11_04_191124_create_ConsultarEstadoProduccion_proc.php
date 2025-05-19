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
        // Asegura que no exista previamente
        DB::unprepared("DROP PROCEDURE IF EXISTS ConsultarEstadoProduccion");

        DB::unprepared("CREATE PROCEDURE ConsultarEstadoProduccion(IN produccion_id INT)
BEGIN
    SELECT p.pro_nombre, p.pro_fecha_inicio, p.pro_fecha_fin, e.eta_nombre AS estado_actual
    FROM produccion AS p
    JOIN etapas AS e ON p.pro_etapa = e.id_etapas
    WHERE p.id_produccion = produccion_id;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS ConsultarEstadoProduccion");
    }
};
