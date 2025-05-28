<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoDocSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tipo_doc')->insert([
            ['tip_doc_descripcion' => 'PPT'],
            ['tip_doc_descripcion' => 'Cédula de Ciudadanía'],
            ['tip_doc_descripcion' => 'Tarjeta de Identidad'],
        ]);
    }
}
