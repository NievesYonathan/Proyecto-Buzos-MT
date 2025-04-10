<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class TipoDocController extends Controller
{
    protected $apiUrl;

    public function __construct()
    {
        $this->apiUrl = url('/api/tipos-documentos');
    }

    public function index()
    {
        $tipoDocumentos = \App\Models\TipoDoc::all(); // sin llamada HTTP
        return view('Perfil-Admin-Usuarios.tipoDocumentos', compact('tipoDocumentos'));
    }

    public function create()
    {
        return view('tipoDocumentos');
    }

    public function store(Request $request)
    {
        $request->validate([
            'tip_doc_descripcion' => 'required|string|max:255',
        ]);

        Http::post($this->apiUrl, [
            'tip_doc_descripcion' => $request->tip_doc_descripcion,
        ]);

        return redirect()->route('tipoDocumentos')->with('success', 'Tipo de documento creado correctamente');
    }

    public function update(Request $request, $id)
    {
        Http::put("{$this->apiUrl}/{$id}", [
            'tip_doc_descripcion' => $request->tip_doc_descripcion,
        ]);

        return redirect()->route('tipoDocumentos')->with('success', 'Descripción actualizada correctamente.');
    }
}
