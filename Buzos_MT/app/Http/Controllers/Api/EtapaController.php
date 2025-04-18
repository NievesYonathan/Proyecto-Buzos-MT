<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Etapas;
use Illuminate\Http\Request;

class EtapaController extends Controller
{
    // Obtener todas las etapas
    public function index()
    {
        $etapas = Etapas::all();
        return response()->json($etapas);
    }

    // Crear una nueva etapa
    public function store(Request $request)
    {
        // Validar los datos de entrada
        $request->validate([
            'eta_nombre' => 'required|string|max:45',
            'eta_descripcion' => 'required|string|max:100',
        ]);

        $etapa = Etapas::create([
            'eta_nombre' => $request->eta_nombre,
            'eta_descripcion' => $request->eta_descripcion,
        ]);

        return response()->json($etapa, 201);
    }

    // Obtener una etapa por ID
    public function show($id)
    {
        $etapa = Etapas::find($id);

        if (!$etapa) {
            return response()->json(['message' => 'Etapa no encontrada'], 404);
        }
        return response()->json($etapa);
    }

    // Actualizar una etapa existente
    public function update(Request $request, $id)
    {
        $etapa = Etapas::find($id);

        if (!$etapa) {
            return response()->json(['message' => 'Etapa no encontrada'], 404);
        }

        $request->validate([
            'eta_nombre' => 'required|string|max:45',
            'eta_descripcion' => 'required|string|max:100',
        ]);

        $etapa->update([
            'eta_nombre' => $request->eta_nombre,
            'eta_descripcion' => $request->eta_descripcion,
        ]);

        return response()->json($etapa);
    }

    // Eliminar una etapa
    public function destroy($id)
{
    $etapa = Etapas::find($id);

    if (!$etapa) {
        return response()->json(['message' => 'Etapa no encontrada'], 404);
    }

    $etapa->delete();

    return redirect()->route('perfil-produccion.etapas')->with('success', 'Etapa eliminada exitosamente.');
}

    // Mostrar la vista con todas las etapass
    public function indexView()
    {
        $etapas = Etapas::all();

        return view('Perfil_Produccion.etapas', compact('etapas'));
    }

    // Crear una nueva etapa desde la vista
    public function storeFromView(Request $request)
    {
        $request->validate([
            'eta_nombre' => 'required|string|max:45',
            'eta_descripcion' => 'required|string|max:100',
        ]);

        $etapa = Etapas::create([
            'eta_nombre' => $request->eta_nombre,
            'eta_descripcion' => $request->eta_descripcion,
        ]);

        return redirect()->route('perfil-produccion.etapas')->with('success', 'Etapa creada exitosamente.');
    }

    // Mostrar la vista de actualización
    public function updateView($id)
    {
        $etapa = Etapas::find($id);

        if (!$etapa) {
            return redirect()->route('perfil-produccion.etapas')->with('error', 'Etapa no encontrada.');
        }

        return view('Perfil_Produccion.update_etapa', compact('etapa'));
    }

    // Actualizar una etapa desde la vista
    public function updateFromView(Request $request, $id)
    {
        $etapa = Etapas::find($id);

        if (!$etapa) {
            return redirect()->route('perfil-produccion.etapas')->with('error', 'Etapa no encontrada.');
        }

        $request->validate([
            'eta_nombre' => 'required|string|max:45',
            'eta_descripcion' => 'required|string|max:100',
        ]);

        $etapa->update([
            'eta_nombre' => $request->eta_nombre,
            'eta_descripcion' => $request->eta_descripcion,
        ]);

        return redirect()->route('perfil-produccion.etapas')->with('success', 'Etapa actualizada exitosamente.');
    }
}
