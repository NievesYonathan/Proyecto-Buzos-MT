<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EtapasSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('etapas')->insert([
            [
                'id_etapas' => 1,
                'eta_nombre' => 'Planificación',
                'eta_descripcion' => 'Definición de tareas y asignación de recursos.'
            ],
            [
                'id_etapas' => 2,
                'eta_nombre' => 'Producción',
                'eta_descripcion' => 'Fase en la que se realiza la fabricación del producto.'
            ],
            [
                'id_etapas' => 3,
                'eta_nombre' => 'Finalización',
                'eta_descripcion' => 'Revisión final y entrega del producto terminado.'
            ],
        ]);
    }
}
