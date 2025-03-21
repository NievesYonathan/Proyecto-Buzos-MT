<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Tarea;
use App\Models\EmpTarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TareaController extends Controller
{
    public function index()
    {
        $tareas = Tarea::with('estados')->get();
        $estados = Estado::all();
        return view('Perfil_Produccion.nueva_tarea', compact('tareas', 'estados'));
    }

    public function update(Request $request, $id)
    {
        // Validar datos
        $request->validate([
            'tar_nombre' => 'string|max:50',
            'tar_descripcion' => 'string|max:200',
            'tar_estado' => 'numeric'
        ]);

        // Buscar la tarea a actualizar
        $tarea = Tarea::findOrFail($id);

        // Actualizar los campos
        $tarea->update([
            'tar_nombre' => $request->tar_nombre,
            'tar_descripcion' => $request->tar_descripcion,
            'tar_estado' => $request->tar_estado
        ]);

        return redirect()->back();
    }

    public function store(Request $request)
    {
        // Validar datos
        $request->validate([
            'tar_nombre' => 'required|string|max:50',
            'tar_descripcion' => 'required|string|max:200',
        ]);

        try {
            Tarea::create([
                'tar_nombre' => $request->tar_nombre,
                'tar_descripcion' => $request->tar_descripcion,
                'tar_estado' => 1
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un problema al crear la tarea.');
        }

        return redirect()->route('pro_tareas')->with('success', 'Tarea creada exitosamente.');
    }

    public function tareasAsignadas()
    {
        $userId = Auth::user()->num_doc;

        // Consulta las tareas relacionadas al usuario autenticado
        $tareasAsignadas = Tarea::whereHas('empleados', function ($query) use ($userId) {
            $query->where('empleados_num_doc', $userId); // Filtra por el usuario autenticado
        })
        ->with(['empleados' => function($query) use ($userId) {
            $query->where('empleados_num_doc', $userId); // Asegúrate de que solo se traigan los empleados correspondientes
        }])
        ->get();

        $estados = Estado::all();

        return view('Perfil-Operario.tareasAsignadas', compact('tareasAsignadas', 'estados'));
    }

    //nueva funcion para actualizar estado perfil operario
    public function editarEstado($id_tarea, $id_empleado_tarea)
{
    // Cargar la tarea y empleado correspondiente
    $tarea = Tarea::findOrFail($id_tarea);
    $empleadoTarea = EmpTarea::findOrFail($id_empleado_tarea);
    $estados = Estado::all();

    return view('Perfil-Operario.editarEstado', compact('tarea', 'empleadoTarea', 'estados'));
}

    public function actualizarEstado(Request $request, $id_tarea, $id_empleado_tarea)
    {
        $request->validate([
            'estadoTarea' => 'required|numeric',
        ]);

        // Actualizar el estado de la tarea para el empleado
        $empleadoTarea = EmpTarea::findOrFail($id_empleado_tarea);
        $empleadoTarea->emp_tar_estado_tarea = $request->estadoTarea;
        $empleadoTarea->save();

        return redirect()->route('tarea.editar', ['id_tarea' => $id_tarea, 'id_empleado_tarea' => $id_empleado_tarea])->with('success', 'Estado actualizado correctamente');
    }
}
