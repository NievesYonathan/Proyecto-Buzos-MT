<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CargosHasUsuariosSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('cargos_has_usuarios')->insert([
            [
                'cargos_id_cargos' => 2,
                'usuarios_num_doc' => 4869681,
                'fecha_asignacion' => Carbon::now(),
                'estado_asignacion' => 1
            ]
        ]);
    }
}
