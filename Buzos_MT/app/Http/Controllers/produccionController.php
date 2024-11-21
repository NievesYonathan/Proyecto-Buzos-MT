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

        $etapas = Etapas::all();

        $materiasPrimas1 = MateriaPrima::all();

        $operarios = User::whereHas('cargos', function ($query) {
            $query->where('id_cargos', 3);
        })->get();

        return view('Perfil_Produccion.pro_fabricados', compact('producciones', 'todasTareas', 'operarios', 'etapas', 'materiasPrimas1'));
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
        // Validar los datos de entrada
        $request->validate([
            'produccion_nombre' => 'required|string|max:50',
            'produccion_fecha_fin' => 'required|date',
            'produccion_cantidad' => 'required|numeric',
            'produccion_etapa' => 'required|exists:etapas,id_etapas',
            'produccion_tarea' => 'required|array',
            'produccion_tarea.*' => 'required|exists:tarea,id_tarea',
            'produccion_responsable' => 'required|array',
            'produccion_responsable.*' => 'required|exists:usuarios,num_doc',
            'produccion_fecha_entrega' => 'required|array',
            'produccion_fecha_entrega.*' => 'required|date',
        ]);
    
        // Buscar la producción que se va a actualizar
        $produccion = Produccion::findOrFail($id);
    
        // Actualizar los campos principales de la producción
        $produccion->update([
            'pro_nombre' => $request->produccion_nombre,
            'pro_fecha_fin' => $request->produccion_fecha_fin,
            'pro_cantidad' => $request->produccion_cantidad,
            'pro_etapa_id' => $request->produccion_etapa,
        ]);
    
        // Actualizar las materias primas asociadas
        foreach ($request->produccion_mtPrima as $key => $materiaPrimaId) {
            $materiaPrimaPivot = $produccion->materiasPrimas()->where('id_pro_materia_prima', $materiaPrimaId)->first();
    
            if ($materiaPrimaPivot) {
                $materiaPrimaPivot->pivot->update([
                    'reg_pmp_cantidad_usada' => $request->mtPrima_cantidad[$key],
                    'reg_pmp_fecha_registro' => now(),
                ]);
            }
        }
    
        // Actualizar las tareas asociadas
        foreach ($request->produccion_tarea as $key => $tareaId) {
            $tareaPivot = $produccion->tareas()->where('tarea_id_tarea', $tareaId)->first();
    
            if ($tareaPivot) {
                $tareaPivot->pivot->update([
                    'emp_tar_fecha_entrega' => $request->produccion_fecha_entrega[$key],
                    'empleados_num_doc' => $request->produccion_responsable[$key],
                ]);
            }
        }
    
        // Redirigir o retornar una respuesta de éxito
        return redirect()->back()->with('success', 'Producción registrada exitosamente.');
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
            'produccion_mtPrima.*' => 'required|integer|exists:materia_prima,id_materia_prima',
            'mtPrima_cantidad.*' => 'required|integer|min:1',
            'produccion_tarea.*' => 'required|integer|exists:tarea,id_tarea',
            'produccion_responsable.*' => 'required|integer|exists:usuarios,num_doc',
            'produccion_fecha_entrega.*' => 'required|date|after_or_equal:produccion_fecha_inicio',
        ]);

        // Crear Producción
        $produccion = Produccion::create([
            'pro_nombre' => $request->produccion_nombre,
            'pro_fecha_inicio' => $request->produccion_fecha_inicio,
            'pro_fecha_fin' => $request->produccion_fecha_fin,
            'pro_cantidad' => $request->produccion_cantidad,
            'pro_etapa' => $request->produccion_etapa,
        ]);

        // Asociar Materia Prima
        foreach ($request->produccion_mtPrima as $key => $materiaPrimaId) {
            $produccion->materiasPrimas()->attach($materiaPrimaId, [
                'reg_pmp_cantidad_usada' => $request->mtPrima_cantidad[$key],
                'reg_pmp_fecha_registro' => now()
            ]);
        }

        // Asociar Tareas
        foreach ($request->produccion_tarea as $key => $tareaId) {
            $produccion->tareas()->attach($tareaId, [
                'id_empleado_tarea' => $key, // O el identificador correspondiente
                'emp_tar_fecha_asignacion' => now(),
                'emp_tar_fecha_entrega' => $request->produccion_fecha_entrega[$key],
                'empleados_num_doc' => $request->produccion_responsable[$key],
                'emp_tar_estado_tarea' => 1,
            ]);
        }

        // Redireccionar con mensaje de éxito
        return redirect()->back()->with('success', 'Producción registrada exitosamente.');
    }
}
