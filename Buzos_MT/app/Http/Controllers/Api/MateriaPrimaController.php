<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MateriaPrima;

class MateriaPrimaController extends Controller
{
    // Obtener todos los registros
    public function index()
    {
        $datos = MateriaPrima::all();
        return response()->json($datos, 200);
    }

    // Crear un nuevo registro
    public function store(Request $request)
    {
        $request->validate([
            'mat_pri_nombre' => 'required|string|max:255',
            'mat_pri_descripcion' => 'nullable|string',
            'mat_pri_unidad_medida' => 'required|string|max:50',
            'mat_pri_cantidad' => 'required|integer|min:1',
            'mat_pri_estado' => 'required|boolean',
            'fecha_compra_mp' => 'required|date',
            'proveedores_id_proveedores' => 'required|integer'
        ]);

        $nuevoDato = MateriaPrima::create($request->only([
            'mat_pri_nombre',
            'mat_pri_descripcion',
            'mat_pri_unidad_medida',
            'mat_pri_cantidad',
            'mat_pri_estado',
            'fecha_compra_mp',
            'proveedores_id_proveedores'
        ]));

        return response()->json($nuevoDato, 201);
    }

    public function buscar(Request $request)
    {
        // Validación de la solicitud
        $request->validate([
            'nombre' => 'required|string'
        ]);

        $nombre = $request->query('nombre');
        $resultados = MateriaPrima::where('mat_pri_nombre', 'LIKE', '%' . $nombre . '%')->get();

        return response()->json($resultados);
    }

    // Obtener un solo registro
    public function show($id)
    {
        $dato = MateriaPrima::find($id);
        if (!$dato) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }
        return response()->json($dato, 200);
    }

    // Actualizar un registro
    public function update(Request $request, $id)
    {
        $dato = MateriaPrima::find($id);
        if (!$dato) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        // Validar solo los campos enviados en la solicitud
        $request->validate([
            'mat_pri_nombre' => 'sometimes|required|string|max:255',
            'mat_pri_descripcion' => 'nullable|string',
            'mat_pri_unidad_medida' => 'sometimes|required|string|max:50',
            'mat_pri_cantidad' => 'sometimes|required|integer|min:1',
            'mat_pri_estado' => 'sometimes|required|boolean',
            'fecha_compra_mp' => 'sometimes|required|date'
        ]);

        $dato->update($request->only([
            'mat_pri_nombre',
            'mat_pri_descripcion',
            'mat_pri_unidad_medida',
            'mat_pri_cantidad',
            'mat_pri_estado',
            'fecha_compra_mp',
            'proveedores_id_proveedores'
        ]));

        if (!$request->expectsJson()) {
            return redirect()->route('lista-item')->with('success', 'Materia prima actualizada correctamente.');
        }

        return response()->json($dato, 200);
    }

    // Eliminar un registro
    public function destroy($id)
    {
        $dato = MateriaPrima::find($id);
        if (!$dato) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $dato->delete();
        return response()->json(['message' => 'Registro eliminado'], 200);
    }
}
