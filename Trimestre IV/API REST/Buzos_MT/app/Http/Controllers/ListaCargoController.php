<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class ListaCargoController extends Controller
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
        $usuariosResponse = Http::get("{$this->apiBase}/usuarios-cargos");
        $cargosResponse = Http::get("{$this->apiBase}/cargos");

        if (!$usuariosResponse->successful() || !$cargosResponse->successful()) {
            throw new \Exception('Error al obtener los datos');
        }

        // Obtener estructura paginada desde la respuesta JSON
        $data = $usuariosResponse->json();

        $usuarios = new LengthAwarePaginator(
            collect($data['data'])->map(function ($usuario) {
                // Convertir relaciones internas a objetos para Blade
                $usuario = (object) $usuario;

                // Asegurarte de que tipo_documento sea un objeto
                $usuario->tipo_documento = isset($usuario->tipo_documento) ? (object) $usuario->tipo_documento : null;
                $usuario->cargos = isset($usuario->cargos) ? collect($usuario->cargos)->map(fn($c) => (object) $c) : collect([]);

                return $usuario;
            }),
            $data['total'],
            $data['per_page'],
            $data['current_page'],
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('Perfil-Admin-Usuarios.user-list-cargo', [
            'usuarios' => $usuarios,
            'cargos' => collect($cargosResponse->json()),
        ]);
    } catch (\Exception $e) {
        return back()->with('error', 'Error de conexión con el servidor');
    }
}


    public function store(Request $request)
    {
        try {
            $response = Http::post("{$this->apiBase}/usuarios-cargos", $request->all());

            if ($response->successful()) {
                return redirect()->route('user-list-cargo')->with('success', 'Cargo asignado correctamente.');
            }

            return back()->withErrors(['error' => $response->json()['message'] ?? 'Error al asignar cargo']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error de conexión con el servidor']);
        }
    }
}
