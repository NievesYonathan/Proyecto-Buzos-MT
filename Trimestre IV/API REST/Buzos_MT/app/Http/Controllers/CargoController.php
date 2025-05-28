<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CargoController extends Controller
{
    private $apiBase;

    public function __construct()
    {
        $this->apiBase = 'http://localhost/dash/Proyecto-Buzos-MT/Trimestre IV/API REST/Buzos_MT/public/api';
        Http::timeout(5);
    }

    public function index()
    {
        try {
            $response = Http::get("{$this->apiBase}/cargos");

            if (!$response->successful()) {
                throw new \Exception('Error al obtener los cargos');
            }

            return view('Perfil-Admin-Usuarios.cargos', [
                'cargos' => $response->json()
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Error de conexión con el servidor');
        }
    }

    public function create()
    {
        return view('Perfil-Admin-Usuarios.cargos-new'); // Crea esta vista si no existe
    }

    public function store(Request $request)
    {
        try {
            $response = Http::post("{$this->apiBase}/cargos", $request->all());

            if ($response->successful()) {
                return redirect()->route('cargos')->with('success', 'Cargo creado correctamente');
            }

            return back()->withErrors(['error' => $response->json()['message'] ?? 'Error al crear cargo'])->withInput();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error de conexión con el servidor'])->withInput();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $response = Http::put("{$this->apiBase}/cargos/{$id}", $request->all());

            if ($response->successful()) {
                return redirect()->route('cargos')->with('success', 'Cargo actualizado correctamente');
            }

            return back()->withErrors(['error' => $response->json()['message'] ?? 'Error al actualizar cargo']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error de conexión con el servidor']);
        }
    }
}
