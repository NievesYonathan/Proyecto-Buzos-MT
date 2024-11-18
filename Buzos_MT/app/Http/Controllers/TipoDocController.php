<?php

namespace App\Http\Controllers;

use App\Models\TipoDoc; 

use Illuminate\Http\Request;

class tipoDocController extends Controller
{
    public function index()
{
    $tiposDocumentos = TipoDoc::all(); // Reemplaza con tu lógica
    return view('Perfil-Admin-Usuarios.tipoDocumentos', compact('tiposDocumentos'));
}

public function store(Request $request)
{
    // Validar los datos del formulario
    $request->validate([
        'nombreDoc' => 'required|max:255', // Ejemplo de validación para nombreDoc
    ]);

    // Lógica para almacenar el tipo de documento
    TipoDoc::create([
        'tip_doc_descripcion' => $request->nombreDoc, // Almacena el campo 'nombreDoc' en la base de datos
    ]);

    // Redirigir con un mensaje de éxito
    return redirect()->route('tipoDoc')->with('success', 'Tipo de documento creado exitosamente');
}

public function update(Request $request, $id)
{
    // Lógica para actualizar el tipo de documento
}

}
