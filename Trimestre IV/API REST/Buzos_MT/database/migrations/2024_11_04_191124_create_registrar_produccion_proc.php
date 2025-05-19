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
                 DB::unprepared("DROP PROCEDURE IF EXISTS registrar_produccion");

        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `registrar_produccion`(IN `p_id_produccion` INT, IN `p_id_materia_prima` INT)
BEGIN
    -- Restar cantidad de materia prima utilizada
    UPDATE reg_mat_prima
    SET cantidad_disponible = cantidad_disponible - p_cantidad_usada
    WHERE id_materia_prima = p_id_materia_prima;
    
    -- Registrar producción finalizada
    INSERT INTO produccion(id_produccion, fecha, cantidad_producida)
    VALUES (p_id_produccion, NOW(), p_cantidad_usada);
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS registrar_produccion");
    }
};
