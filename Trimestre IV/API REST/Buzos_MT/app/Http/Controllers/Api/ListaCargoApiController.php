<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Cargo;

class ListaCargoApiController extends Controller
{
    public function index()
    {
        $usuarios = User::with(['tipoDocumento', 'cargos'])->paginate(10); 
        return response()->json($usuarios, 200);
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

        return response()->json(['message' => 'Cargo asignado correctamente'], 200);
    }
}
