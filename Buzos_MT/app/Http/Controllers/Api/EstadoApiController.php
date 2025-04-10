<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoApiController extends Controller
{
    public function index()
    {
        $estados = Estado::all();
        return response()->json(['estados' => $estados]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_estado' => 'required|string|max:255',
        ]);

        $estado = Estado::create([
            'nombre_estado' => $request->nombre_estado,
        ]);

        return response()->json(['message' => 'Estado creado correctamente', 'estado' => $estado]);
    }

    public function update(Request $request, $id_estados)
    {
        $estado = Estado::findOrFail($id_estados);

        $estado->update([
            'nombre_estado' => $request->nombre_estado,
        ]);

        return response()->json(['message' => 'Estado actualizado correctamente', 'estado' => $estado]);
    }
}
