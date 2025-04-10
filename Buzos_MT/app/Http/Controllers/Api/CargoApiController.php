<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Cargo;
use Illuminate\Http\Request;

class CargoApiController extends Controller
{
    public function index()
    {
        $cargos = Cargo::with('usuarios')->paginate(10);
        return response()->json(['cargos' => $cargos]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_nombre' => 'required|string|max:255',
        ]);

        $cargo = Cargo::create([
            'car_nombre' => $request->car_nombre,
        ]);

        return response()->json(['message' => 'Cargo creado correctamente', 'cargo' => $cargo]);
    }

    public function update(Request $request, $id_cargos)
    {
        $cargo = Cargo::findOrFail($id_cargos);

        $cargo->update([
            'car_nombre' => $request->car_nombre,
        ]);

        return response()->json(['message' => 'Cargo actualizado correctamente', 'cargo' => $cargo]);
    }
}
