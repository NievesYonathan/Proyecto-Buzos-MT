<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Cargo;
use Illuminate\Http\Request;

class ListaCargoApiController extends Controller
{
    public function index()
    {
        $usuarios = User::with('cargos')->paginate(10);
        $cargos = Cargo::all();

        return response()->json([
            'usuarios' => $usuarios,
            'cargos' => $cargos
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'numDoc' => 'required|exists:usuarios,num_doc',
            'idCargo' => 'required|array|size:1',
            'idCargo.*' => 'exists:cargos,id_cargos',
        ]);

        $usuario = User::where('num_doc', $request->numDoc)->firstOrFail();

        $cargoConDatos = [
            $request->idCargo[0] => [
                'fecha_asignacion' => now(),
                'estado_asignacion' => 1,
            ],
        ];

        $usuario->cargos()->sync($cargoConDatos);

        return response()->json(['message' => 'Cargo asignado correctamente.']);
    }
}
