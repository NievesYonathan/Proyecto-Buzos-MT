<?php

namespace App\Http\Controllers;

use App\Models\Etapas;
use App\Models\MateriaPrima;
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

        $operarios = User::whereHas('cargos', function ($query) {
            $query->where('id_cargos', 3);
        })->get();

        return view('Perfil_Produccion.pro_fabricados', compact('producciones', 'todasTareas', 'operarios'));
    }

    public function indexTwo()
    {
        // $producciones = Produccion::with('etapa', 'regProFabricados', 'materiasPrimas', 'tareas')->get();

        $tareas = Tarea::all();

        $etapas = Etapas::all();

        $materiasPrimas = MateriaPrima::all();

        $operarios = User::whereHas('cargos', function ($query) {
            $query->where('id_cargos', 3);
        })->get();

        return view('Perfil_Produccion.produccion', compact('etapas', 'operarios', 'tareas', 'materiasPrimas'));
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

    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'produccion_nombre' => 'required|string|max:50',
            'produccion_fecha_inicio' => 'required|date',
            'produccion_fecha_fin' => 'required|date|after_or_equal:produccion_fecha_inicio',
            'produccion_cantidad' => 'required|integer|min:1',
            'produccion_etapa' => 'required|string|max:50',
            'produccion_mtPrima.*' => 'required|integer|exists:materia_primas,id',
            'mtPrima_cantidad.*' => 'required|integer|min:1',
            'produccion_tarea.*' => 'required|integer|exists:tareas,id',
            'produccion_responsable.*' => 'required|integer|exists:users,id',
            'produccion_fecha_entrega.*' => 'required|date|after_or_equal:produccion_fecha_inicio',
        ]);

        // Crear Producción
        $produccion = Produccion::create([
            'nombre' => $request->produccion_nombre,
            'fecha_inicio' => $request->produccion_fecha_inicio,
            'fecha_fin' => $request->produccion_fecha_fin,
            'cantidad' => $request->produccion_cantidad,
            'etapa' => $request->produccion_etapa,
        ]);

        // Asociar Materia Prima
        foreach ($request->produccion_mtPrima as $key => $materiaPrimaId) {
            $produccion->materiasPrimas()->attach($materiaPrimaId, [
                'cantidad' => $request->mtPrima_cantidad[$key],
            ]);
        }

        // Asociar Tareas
        foreach ($request->produccion_tarea as $key => $tareaId) {
            $produccion->tareas()->create([
                'tarea_id' => $tareaId,
                'responsable_id' => $request->produccion_responsable[$key],
                'fecha_entrega' => $request->produccion_fecha_entrega[$key],
            ]);
        }

        // Redireccionar con mensaje de éxito
        return redirect()->back()->with('success', 'Producción registrada exitosamente.');
    }
}