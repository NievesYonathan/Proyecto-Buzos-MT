<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class InformeController extends Controller
{
    public function index()
    {
        $activos = User::where('usu_estado', 1)->count();
        $conCargo = User::has('cargos')->count();
        $inactivos = User::where('usu_estado', 2)->count();

        return view('Perfil-Admin-Usuarios.informe-RRHH', compact('activos', 'conCargo', 'inactivos'));
    }

    public function fetchUsers(Request $request)
    {
        $usuarios = User::with(['tipoDocumento', 'cargos'])->get();

        $queryType = $request->get('queryType');
        $users = match ($queryType) {
            'activos' => User::with(['tipoDocumento', 'cargos'])->where('usu_estado', 1)->get(),
            'cargos' => User::with(['tipoDocumento', 'cargos'])->get(),
            'inactivos' => User::with(['tipoDocumento', 'cargos'])->where('usu_estado', 2)->get(),
            default => collect(),
        };

        return response()->json($users);
    }
}
