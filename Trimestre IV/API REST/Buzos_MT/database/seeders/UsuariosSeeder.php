<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuariosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('usuarios')->insert([
            'num_doc' => 4869681,
            't_doc' => 1, // Ej: Cédula
            'usu_nombres' => 'Yonathan',
            'usu_apellidos' => 'Nieves',
            'usu_fecha_nacimiento' => '2004-10-15',
            'usu_sexo' => 'M',
            'usu_direccion' => 'Calle 123',
            'usu_telefono' => '3011234567',
            'email' => 'yonathannieves17@gmail.com',
            'usu_fecha_contratacion' => '2023-01-01',
            'usu_estado' => 1, // Activo
            'imag_perfil' => null,
            'registro_gmail' => null,
        ]);
    }
}
