<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CargosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('cargos')->insert([
            ['car_nombre' => 'Jefe Inventario'],
            ['car_nombre' => 'Administrador Usuario'],
            ['car_nombre' => 'Jefe Producción'],
            ['car_nombre' => 'Operario'],
            ['car_nombre' => 'Proveedor'],
        ]);
    }
}
