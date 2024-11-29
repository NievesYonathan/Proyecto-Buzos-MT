<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Tarea;
use Google\Service\DriveActivity\Create;
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
        // Vavilar datos
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

        // Retornar la vista de tareas
        return redirect()->back();
    }

    public function store(Request $request)
    {
        // Vavilar datos
        $request->validate([
            'tar_nombre' => 'required|string|max:50',
            'tar_descripcion' => 'required|string|max:200',
        ]);

        // Actualizar los campos
        try {
            Tarea::create([
                'tar_nombre' => $request->tar_nombre,
                'tar_descripcion' => $request->tar_descripcion,
                'tar_estado' => 1
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Ocurrió un problema al crear la tarea.');
        }

        // Retornar la vista de tareas
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
}
