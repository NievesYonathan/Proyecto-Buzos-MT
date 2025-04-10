<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ListaCargoController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = url('/api/lista-cargo');
    }

    public function index()
    {
        $response = Http::get($this->apiUrl);
        $data = $response->json();

        $usuarios = $data['usuarios'] ?? [];
        $cargos = $data['cargos'] ?? [];

        return view('Perfil-Admin-Usuarios.user-list-cargo', compact('usuarios', 'cargos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'numDoc' => 'required',
            'idCargo' => 'required|array|size:1',
        ]);

        Http::post($this->apiUrl, [
            'numDoc' => $request->numDoc,
            'idCargo' => $request->idCargo,
        ]);

        return redirect()->route('user-list-cargo')->with('success', 'Cargo asignado correctamente.');
    }
}
