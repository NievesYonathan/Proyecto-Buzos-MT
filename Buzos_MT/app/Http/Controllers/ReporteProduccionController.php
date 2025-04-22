<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegProFabricado;
use Illuminate\Support\Facades\DB;

class ReporteProduccionController extends Controller
{
    public function index()
{
    $datosProduccion = DB::table('reg_pro_fabricados')
            ->select('reg_pf_tipo_prenda', DB::raw('COUNT(*) as cantidad_total'))
            ->groupBy('reg_pf_tipo_prenda')
        ->get();

return view('perfil_inventario.reporte_inventario', compact('datosProduccion'));
}
}