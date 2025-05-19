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
        DB::unprepared("DROP PROCEDURE IF EXISTS ObtenerDatosSeguridadGmail");

        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerDatosSeguridadGmail`(IN `gmail` VARCHAR(50))
BEGIN
    SELECT 
           u.num_doc, 
           u.t_doc, 
           u.usu_nombres,
           u.usu_apellidos,
           u.usu_estado, 
           u.usu_telefono,
           u.usu_email,
           c.cargos_id_cargos,
           car.car_nombre
    FROM usuarios AS u
    LEFT JOIN cargos_has_usuarios AS c ON u.num_doc = c.usuarios_num_doc
    LEFT JOIN cargos AS car ON c.cargos_id_cargos = car.id_cargos
    WHERE u.usu_email = gmail; 
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS ObtenerDatosSeguridadGmail");
    }
};
