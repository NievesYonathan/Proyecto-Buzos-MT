<?php

namespace App\Http\Controllers;

use App\Models\Produccion;
use App\Models\Tarea;
use App\Models\User;
use Illuminate\Http\Request;

class produccionController extends Controller
{
    public function index()
    {
        $producciones = Produccion::with('etapa', 'regProFabricados', 'materiasPrimas', 'tareas')->get();

        $todasTareas = Tarea::all();

        $operarios = User::whereHas('cargos', function($query) {
            $query->where('id_cargos', 3);
        })->get();

        return view('Perfil_Produccion.pro_fabricados', compact('producciones', 'todasTareas', 'operarios'));    
    }

    public function update(Request $request, $id)
    {
        $validation = $request->validate([
            'produccion_nombre' => 'required|string|max:255',
            'produccion_fecha_inicio' => 'required|date',
            'produccion_fecha_fin' => 'required|date',
            'produccion_cantidad' => 'required|integer',
            'produccion_etapa' => 'required|exists:etapas,id_etapas'
        ]);
    }

}
