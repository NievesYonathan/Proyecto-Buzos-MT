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
        DB::unprepared("DROP PROCEDURE IF EXISTS ObtenerDatosSeguridad");

        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `ObtenerDatosSeguridad`(IN `numero_doc` INT, IN `tipo_doc` INT)
BEGIN
    -- Selecciona datos de la tabla 'seguridad' y descifra la columna 'seg_clave_hash'
    SELECT 
           u.num_doc, 
           u.t_doc, 
           u.usu_nombres,
           u.usu_apellidos,
           u.usu_estado, 
           u.usu_telefono,
           u.usu_email,
           s.seg_clave_hash,
           AES_DECRYPT(s.seg_clave_hash, 'BUZOSMT') AS clave_descifrada,
           c.cargos_id_cargos,
           car.car_nombre
    FROM usuarios AS u
    LEFT JOIN seguridad AS s ON u.num_doc = s.usu_num_doc
    LEFT JOIN cargos_has_usuarios AS c ON u.num_doc = c.usuarios_num_doc
    LEFT JOIN cargos AS car ON c.cargos_id_cargos = car.id_cargos  -- Corregido a car.id_cargos
    WHERE u.t_doc = tipo_doc  -- Aquí deberías sustituir 'tipo_doc' por el valor correspondiente o variable
      AND u.num_doc = numero_doc;  -- Aquí también sustituir 'numero_doc' por el valor correspondiente
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS ObtenerDatosSeguridad");
    }
};
