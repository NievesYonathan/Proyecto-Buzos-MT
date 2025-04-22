<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tarea;
use App\Models\Estado;
use App\Models\EmpTarea;
use Illuminate\Http\Request;


class TareaApiController extends Controller
{
    public function index()
    {
        return response()->json(Tarea::with('estados')->get());
    }

    public function store(Request $request)
    {
        $request->validate([
            'tar_nombre' => 'required|string|max:50',
            'tar_descripcion' => 'required|string|max:200',
        ]);

        $tarea = Tarea::create([
            'tar_nombre' => $request->tar_nombre,
            'tar_descripcion' => $request->tar_descripcion,
            'tar_estado' => 1,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Etapa registrada correctamente',
        ]);
    }

    public function update(Request $request, $id)
    {
        $tarea = Tarea::find($id);

        if (!$tarea) {
            return response()->json(['message' => 'Tarea no encontrada'], 404);
        }

        $request->validate([
            'tar_nombre' => 'required|string|max:50',
            'tar_descripcion' => 'required|string|max:200',
        ]);

        $tarea->update([
            'tar_nombre' => $request->tar_nombre,
            'tar_descripcion' => $request->tar_descripcion,
        ]);

        return response()->json([
            'status' => 200,
            'message' => 'Tarea actualizada correctamente',
        ]);
    }
    

    public function show($id)
    {
        $tarea = Tarea::with('estados')->findOrFail($id);
        return response()->json($tarea);
    }

    public function tareasAsignadas(Request $request)
    {
        $userId = $request->input('num_doc');

        if (!$userId) {
            return response()->json(['error' => 'Falta el parámetro num_doc'], 400);
        }

        $tareas = Tarea::whereHas('empleados', function ($query) use ($userId) {
            $query->where('empleados_num_doc', $userId);
        })->with(['empleados' => function ($query) use ($userId) {
            $query->where('empleados_num_doc', $userId);
        }])->get();

        return response()->json([
            'tareasAsignadas' => $tareas,
            'estados' => Estado::all()
        ]);
    }


    public function editarEstado($id_tarea, $id_empleado_tarea)
    {
        return response()->json([
            'tarea' => Tarea::findOrFail($id_tarea),
            'empleadoTarea' => EmpTarea::findOrFail($id_empleado_tarea),
            'estados' => Estado::all()
        ]);
    }

    public function actualizarEstado(Request $request, $id_empleado_tarea)
    {
        $request->validate([
            'estadoTarea' => 'required|numeric',
        ]);

        $empTarea = EmpTarea::findOrFail($id_empleado_tarea);
        $empTarea->emp_tar_estado_tarea = $request->estadoTarea;
        $empTarea->save();

        return response()->json(['message' => 'Estado actualizado']);
    }
}
