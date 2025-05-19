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
        // Elimina el procedimiento si ya existe
        DB::unprepared("DROP PROCEDURE IF EXISTS ConsultarMateriasPrimasPorProveedor");

        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `ConsultarMateriasPrimasPorProveedor`(IN `proveedor_id` INT)
        BEGIN
            SELECT mp.mat_pri_nombre, mp.mat_pri_cantidad, mp.mat_pri_unidad_medida
            FROM materia_prima AS mp
            WHERE mp.proveedores_id_proveedores = proveedor_id;
        END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS ConsultarMateriasPrimasPorProveedor");
    }
};
