<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CargoController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = url('/api/cargos');
    }

    public function index()
    {
        $response = Http::get($this->apiUrl);
        $data = $response->json();

        $cargos = $data['cargos']['data'] ?? [];

        return view('Perfil-Admin-Usuarios.cargos', compact('cargos'));
    }

    public function create(Request $request)
    {
        $response = Http::get($this->apiUrl);
        $data = $response->json();

        $cargos = $data['cargos']['data'] ?? [];

        return view('cargos', compact('cargos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_nombre' => 'required|string|max:255',
        ]);

        Http::post($this->apiUrl, [
            'car_nombre' => $request->car_nombre,
        ]);

        return redirect()->route('cargos')->with('success', 'Cargo creado correctamente');
    }

    public function update(Request $request, $id_cargos)
    {
        Http::put($this->apiUrl . '/' . $id_cargos, [
            'car_nombre' => $request->car_nombre,
        ]);

        return redirect()->route('cargos')->with('success', 'Cargo actualizado correctamente');
    }
}
