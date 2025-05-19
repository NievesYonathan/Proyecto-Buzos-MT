<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProduccionSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('produccion')->insert([
            [
                'pro_nombre' => 'Buzo Deportivo',
                'pro_fecha_inicio' => '2025-05-20',
                'pro_fecha_fin' => '2025-05-25',
                'pro_cantidad' => 300,
                'pro_etapa' => 1,
            ],
            [
                'pro_nombre' => 'Chaqueta Invierno',
                'pro_fecha_inicio' => '2025-06-01',
                'pro_fecha_fin' => '2025-06-10',
                'pro_cantidad' => 150,
                'pro_etapa' => 2,
            ],
        ]);
    }
}
