<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class TipoDocController extends Controller
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
            $response = Http::get("{$this->apiBase}/tipos-documentos");

            if (!$response->successful()) {
                throw new \Exception('Error al obtener tipos de documentos');
            }

            return view('Perfil-Admin-Usuarios.tipoDocumentos', [
                'tipoDocumentos' => $response->json()
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Error de conexión con el servidor');
        }
    }

    public function create()
    {
        return view('Perfil-Admin-Usuarios.tipoDocumentos-new');
    }

    public function store(Request $request)
    {
        try {
            $response = Http::post("{$this->apiBase}/tipos-documentos", $request->all());

            if ($response->successful()) {
                return redirect()->route('tipoDocumentos')->with('success', 'Tipo de documento creado correctamente');
            }

            $errorMessage = $response->json()['message'] ?? 'Error al crear tipo de documento';
            return back()->withErrors(['error' => $errorMessage])->withInput();
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error de conexión con el servidor'])->withInput();
        }
    }

    public function update(Request $request, $id_tipo_documento)
    {
        try {
            $response = Http::put("{$this->apiBase}/tipos-documentos/{$id_tipo_documento}", $request->all());

            if ($response->successful()) {
                return redirect()->route('tipoDocumentos')->with('success', 'Descripción actualizada correctamente');
            }

            return back()->withErrors(['error' => $response->json()['message'] ?? 'Error al actualizar']);
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error de conexión con el servidor']);
        }
    }
}
