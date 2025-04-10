<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EstadoController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = url('/api/estados');
    }

    public function index()
    {
        $response = Http::get($this->apiUrl);
        $data = $response->json();

        $estados = $data['estados'] ?? [];

        return view('Perfil-Admin-Usuarios.vistaEstados', compact('estados'));
    }

    public function crearEstado(Request $request)
    {
        $request->validate([
            'nombre_estado' => 'required|string|max:255',
        ]);

        Http::post($this->apiUrl, [
            'nombre_estado' => $request->nombre_estado,
        ]);

        return redirect()->back()->with('success', 'Estado creado correctamente.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_estado' => 'required|string|max:255',
        ]);

        Http::post($this->apiUrl, [
            'nombre_estado' => $request->nombre_estado,
        ]);

        return redirect()->route('vistaEstados')->with('success', 'Estado creado correctamente');
    }

    public function update(Request $request, $id_estados)
    {
        Http::put($this->apiUrl . '/' . $id_estados, [
            'nombre_estado' => $request->nombre_estado,
        ]);

        return redirect()->route('vistaEstados')->with('success', 'Estado actualizado correctamente.');
    }
}
