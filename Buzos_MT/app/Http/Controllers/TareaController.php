<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\Tarea;
use Illuminate\Http\Request;

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
}
