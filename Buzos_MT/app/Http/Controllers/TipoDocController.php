<?php

namespace App\Http\Controllers;

use App\Models\TipoDoc;

use Illuminate\Http\Request;

class tipoDocController extends Controller
{
    public function index()
    {
        $tipoDocumentos = TipoDoc::all(); // Reemplaza con tu lógica
        return view('Perfil-Admin-Usuarios.tipoDocumentos', compact('tipoDocumentos'));
    }

    public function create()
    {
        $tipoDocumentos = TipoDoc::all();
        // Aquí podrías retornar la vista donde se muestra el formulario.
        return view('tipoDocumentos');
    }
    /**
     * Almacena un nuevo tipo de documento en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos antes de almacenarlos
        $validated = $request->validate([
            'tip_doc_descripcion' => 'required|string|max:255',  // Validación del campo nombre

        ]);

        // Crear un nuevo tipo de documento
        $tipoDocumentos = new TipoDoc();
        $tipoDocumentos->tip_doc_descripcion = $validated['tip_doc_descripcion'];


        // Guardar en la base de datos
        $tipoDocumentos->save();

        // Redirigir o devolver una respuesta (puede ser JSON, o redirigir a la lista)
        return redirect()->route('tipoDocumentos')->with('success', 'Tipo de documento creado correctamente');
    }

    public function update(Request $request, $id_tipo_documento)
    {
        $tipoDocumentos = TipoDoc::where('id_tipo_documento', $id_tipo_documento)->first();


        // Actualiza solo los campos que están presentes en el request
        $tipoDocumentos->update([
            'tip_doc_descripcion' => $request->tip_doc_descripcion,

        ]);

        return redirect()->route('tipoDocumentos')->with('success', 'descripcion actualizada correctamente.');
    }
}
