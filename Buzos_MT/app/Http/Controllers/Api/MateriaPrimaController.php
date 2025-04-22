<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MateriaPrima;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'mat_pri_nombre' => 'required|string|max:255',
            'mat_pri_descripcion' => 'nullable|string',
            'mat_pri_unidad_medida' => 'required|string|max:50',
            'mat_pri_cantidad' => 'required|integer|min:1',
            'mat_pri_estado' => 'required|boolean',
            'fecha_compra_mp' => 'required|date',
            'proveedores_id_proveedores' => 'required|integer'
        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $materiaPrima = MateriaPrima::create([
            'mat_pri_nombre' => $request->mat_pri_nombre,
            'mat_pri_descripcion' => $request->mat_pri_descripcion,
            'mat_pri_unidad_medida' => $request->mat_pri_unidad_medida,
            'mat_pri_cantidad' => $request->mat_pri_cantidad,
            'mat_pri_estado' => $request->mat_pri_estado,
            'fecha_compra_mp' => $request->fecha_compra_mp,
            'proveedores_id_proveedores' => $request->proveedores_id_proveedores
        ]);

        if(!$materiaPrima){
            $data = [
                'message' => 'Error al crear el registro',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'Materia Prima' => $materiaPrima,
            'status' => 201
        ];

        return response()->json($data, 201);
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
        $materiaPrima = MateriaPrima::find($id);
        if (!$materiaPrima) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        // Validar solo los campos enviados en la solicitud
        $validator = Validator::make($request->all(), [
            'mat_pri_nombre' => 'sometimes|required|string|max:255',
            'mat_pri_descripcion' => 'nullable|string',
            'mat_pri_unidad_medida' => 'sometimes|required|string|max:50',
            'mat_pri_cantidad' => 'sometimes|required|integer|min:1',
            'mat_pri_estado' => 'sometimes|required|boolean',
            'fecha_compra_mp' => 'sometimes|required|date'
        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $materiaPrima->mat_pri_nombre = $request->mat_pri_nombre;
        $materiaPrima->mat_pri_descripcion = $request->mat_pri_descripcion;
        $materiaPrima->mat_pri_unidad_medida = $request->mat_pri_unidad_medida;
        $materiaPrima->mat_pri_cantidad = $request->mat_pri_cantidad;
        $materiaPrima->mat_pri_estado = $request->mat_pri_estado;
        $materiaPrima->fecha_compra_mp = $request->fecha_compra_mp;
        $materiaPrima->proveedores_id_proveedores = $request->proveedores_id_proveedores;

        $materiaPrima->save();

        if (!$request->expectsJson()) {
            return redirect()->route('lista-item')->with('success', 'Materia prima actualizada correctamente.');
        }

        $data = [
            'message' => 'Registro actualizado',
            'producto' => $materiaPrima,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    // Eliminar un registro
    public function delete($id)
    {
        $dato = MateriaPrima::find($id);
        if (!$dato) {
            return response()->json(['message' => 'Registro no encontrado'], 404);
        }

        $dato->delete();
        return response()->json(['message' => 'Registro eliminado'], 200);
    }
}
