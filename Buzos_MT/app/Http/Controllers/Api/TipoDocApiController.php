<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\TipoDoc;
use Illuminate\Http\Request;

class TipoDocApiController extends Controller
{
    public function index()
    {
        return TipoDoc::all();
    }

    public function store(Request $request)
    {
        $request->validate([
            'tip_doc_descripcion' => 'required|string|max:255',
        ]);

        return TipoDoc::create([
            'tip_doc_descripcion' => $request->tip_doc_descripcion,
        ]);
    }

    public function update(Request $request, $id)
    {
        $tipo = TipoDoc::findOrFail($id);

        $tipo->update([
            'tip_doc_descripcion' => $request->tip_doc_descripcion,
        ]);

        return response()->json($tipo);
    }

    public function destroy($id)
    {
        $tipo = TipoDoc::findOrFail($id);
        $tipo->delete();

        return response()->json(['message' => 'Eliminado correctamente']);
    }

    public function show($id)
    {
        return TipoDoc::findOrFail($id);
    }
}
