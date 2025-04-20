<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\TipoDoc;
use Illuminate\Http\Request;

class TipoDocApiController extends Controller
{
    public function index()
    {
        return response()->json(TipoDoc::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'tip_doc_descripcion' => 'required|string|max:255',
        ]);

        $tipoDoc = TipoDoc::create([
            'tip_doc_descripcion' => $request->tip_doc_descripcion,
        ]);

        return response()->json(['message' => 'Tipo de documento creado', 'data' => $tipoDoc], 201);
    }

    public function update(Request $request, $id)
    {
        $tipoDoc = TipoDoc::findOrFail($id);

        $request->validate([
            'tip_doc_descripcion' => 'required|string|max:255',
        ]);

        $tipoDoc->update([
            'tip_doc_descripcion' => $request->tip_doc_descripcion,
        ]);

        return response()->json(['message' => 'Tipo de documento actualizado', 'data' => $tipoDoc]);
    }
}
