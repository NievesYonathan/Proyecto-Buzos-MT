<?php

namespace App\Http\Controllers\Api;

use App\Models\Estado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EstadoApiController extends Controller
{
    // Obtener todos los estados
    public function index()
    {
        $estados = Estado::all();
        return response()->json($estados, 200); // 200 OK
    }

    // Crear un nuevo estado
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre_estado' => 'required|string|max:255',  // Validación del campo nombre
        ]);

        $estado = Estado::create([
            'nombre_estado' => $validated['nombre_estado']
        ]);

        return response()->json([
            'message' => 'Estado creado con éxito',
            'estado' => $estado
        ], 201); // 201 Created
    }

    // Actualizar un estado existente
    public function update(Request $request, $id_estados)
    {
        $estado = Estado::find($id_estados);

        if (!$estado) {
            return response()->json(['message' => 'Estado no encontrado'], 404); // 404 Not Found
        }

        $estado->update([
            'nombre_estado' => $request->nombre_estado
        ]);

        return response()->json([
            'message' => 'Estado actualizado correctamente',
            'estado' => $estado
        ], 200); // 200 OK
    }

    // Eliminar un estado
    public function destroy($id_estados)
    {
        $estado = Estado::find($id_estados);

        if (!$estado) {
            return response()->json(['message' => 'Estado no encontrado'], 404); // 404 Not Found
        }

        $estado->delete();

        return response()->json(['message' => 'Estado eliminado correctamente'], 200); // 200 OK
    }
}
