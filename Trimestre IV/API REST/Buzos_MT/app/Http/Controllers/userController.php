<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
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
            $response = Http::get("{$this->apiBase}/usuarios");
            $tiposResponse = Http::get("{$this->apiBase}/tipos-documentos");
            $estadosResponse = Http::get("{$this->apiBase}/estados");

            if (!$response->successful() || !$tiposResponse->successful() || !$estadosResponse->successful()) {
                throw new \Exception('Error al obtener datos de la API');
            }

            return view('Perfil-Admin-Usuarios.user-list', [
                'usuarios' => $response->json(),
                'tiposDocumentos' => $tiposResponse->json(),
                'estados' => $estadosResponse->json()
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Error de conexión con el servidor');
        }
    }

    public function create()
    {
        try {
            $response = Http::get("{$this->apiBase}/tipos-documentos");
            
            if (!$response->successful()) {
                throw new \Exception('Error al obtener tipos de documentos');
            }

            return view('Perfil-Admin-Usuarios.user-new', ['tipos_documentos' => $response->json()]);
        } catch (\Exception $e) {
            return back()->with('error', 'Error de conexión con el servidor');
        }
    }

    public function store(Request $request)
    {
        try {
            $response = Http::post("{$this->apiBase}/usuarios", $request->all());

            if ($response->successful()) {
                return redirect()->route('user-list')->with('alerta', 'Usuario creado con éxito');
            }

            $errorMessage = $response->json()['message'] ?? $response->json()['error'] ?? 'Error al crear usuario';
            return back()->withErrors(['error' => $errorMessage])->withInput();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error de conexión con el servidor'])->withInput();
        }
    }

    public function update(Request $request, $num_doc)
    {
        try {
            $response = Http::put("{$this->apiBase}/usuarios/{$num_doc}", $request->all());

            if ($response->successful()) {
                return redirect()->route('user-list')->with('alerta', 'Usuario actualizado correctamente');
            }

            return back()->withErrors(['error' => $response->json()['message'] ?? 'Error al actualizar usuario']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error de conexión con el servidor']);
        }
    }

    public function cambiarestado($num_doc)
    {
        try {
            $response = Http::put("{$this->apiBase}/usuarios/cambiar-estado/{$num_doc}");

            if ($response->successful()) {
                return redirect()->route('user-list')->with('alerta', 'Estado actualizado correctamente');
            }

            return back()->withErrors(['error' => $response->json()['message'] ?? 'Error al cambiar estado']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error de conexión con el servidor']);
        }
    }

    public function buscar(Request $request)
    {
        try {
            $search = $request->input('search', '');
            
            if ($search) {
                $response = Http::get("{$this->apiBase}/usuarios/buscar", ['search' => $search]);
                $resultado = $response->successful() ? collect($response->json()) : collect([]);
            } else {
                $resultado = collect([]);
            }

            return view('Perfil-Admin-Usuarios.user-search', compact('search', 'resultado'));
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error de conexión con el servidor']);
        }
    }
}
