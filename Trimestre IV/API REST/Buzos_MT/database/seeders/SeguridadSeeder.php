<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SeguridadSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('seguridad')->insert([
            'usu_num_doc' => 4869681,
            'seg_clave_hash' => Hash::make('123456789'), // Contraseña encriptada
        ]);
    }
}
