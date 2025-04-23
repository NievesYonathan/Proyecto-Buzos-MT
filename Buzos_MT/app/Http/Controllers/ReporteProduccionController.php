<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegProFabricado;
use App\Models\RegProMateriaPrima;
use App\Models\MateriaPrima;
use Illuminate\Support\Facades\DB;

class ReporteProduccionController extends Controller
{
    public function index()
    {
        // Obtener el total de uso por materia prima
        $materiasPrimas = DB::table('reg_pro_mat_prima as rpmp')
            ->join('materia_prima as mp', 'rpmp.id_pro_materia_prima', '=', 'mp.id_materia_prima')
            ->select(
                'mp.mat_pri_nombre as nombre_materia_prima',
                DB::raw('SUM(rpmp.reg_pmp_cantidad_usada) as cantidad_total_usada')
            )
            ->groupBy('mp.id_materia_prima', 'mp.mat_pri_nombre')
            ->get();

        // Obtener los registros detallados de uso con eager loading específico
        $registrosUso = DB::table('reg_pro_mat_prima as rpmp')
            ->join('materia_prima as mp', 'rpmp.id_pro_materia_prima', '=', 'mp.id_materia_prima')
            ->join('produccion as p', 'rpmp.id_produccion', '=', 'p.id_produccion')
            ->select(
                'rpmp.id_registro',
                'rpmp.reg_pmp_cantidad_usada',
                'rpmp.reg_pmp_fecha_registro',
                'mp.mat_pri_nombre',
                'p.pro_nombre'
            )
            ->orderBy('rpmp.reg_pmp_fecha_registro', 'desc')
            ->get();

        return view('perfil_inventario.reporte_inventario', [
            'materiasPrimas' => $materiasPrimas,
            'registrosUso' => $registrosUso
        ]);
    }
}