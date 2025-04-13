<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    public function index()
    {
        // Obtener todos los estados
        $estados = Estado::all();
        return view('Perfil-Admin-Usuarios.vistaEstados', compact('estados'));
    }

    public function crearEstado(Request $request)
    {
        // Validar y crear un nuevo estado
        $request->validate(['nombre_estado' => 'required|string|max:255']);
        Estado::create(['nombre_estado' => $request->nombre_estado]);

        return redirect()->back()->with('success', 'Estado creado correctamente.');
    }


    public function store(Request $request)
    {
        // Validar los datos antes de almacenarlos
        $validated = $request->validate([
            'nombre_estado' => 'required|string|max:255',  // Validación del campo nombre

        ]);

        // Crear un nuevo tipo de documento
        $estados = new Estado();
        $estados->nombre_estado = $validated['nombre_estado'];


        // Guardar en la base de datos
        $estados->save();

        // Redirigir o devolver una respuesta (puede ser JSON, o redirigir a la lista)
        return redirect()->route('vistaEstados')->with('success', 'Estado creado correctamente');
    }

    public function update(Request $request, $id_estados)
    {
        $estados = Estado::where('id_estados', $id_estados)->first();


        // Actualiza solo los campos que están presentes en el request
        $estados->update([
            'nombre_estado' => $request->nombre_estado,

        ]);

        return redirect()->route('vistaEstados')->with('success', 'estado actualzado actualizada correctamente.');
    }
}
