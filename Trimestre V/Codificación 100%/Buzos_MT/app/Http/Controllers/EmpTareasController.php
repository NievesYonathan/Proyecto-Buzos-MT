<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EmpTarea;
use App\Models\Produccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmpTareasController extends Controller
{
    public function store(Request $request, $id)
    {
        // Validación de entrada
        $validator = Validator::make($request->all(), [
            'empleados_num_doc' => 'required',
            'tarea_id_tarea' => 'required',
            'emp_tar_fecha_asignacion' => 'required',
            'emp_tar_fecha_entrega' => 'required',
            'emp_tar_estado_tarea' => 'required'
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }
    
        // Verificar que la producción existe
        $produccion = Produccion::find($id);
        if (!$produccion) {
            return response()->json([
                'message' => 'Producción no encontrada',
                'status' => 404
            ], 404);
        }
    
        // Creación del registro en la tabla emp_tarea
        $empTarea = EmpTarea::create([
            'empleados_num_doc' => $request->empleados_num_doc,
            'tarea_id_tarea' => $request->tarea_id_tarea,
            'emp_tar_fecha_asignacion' => $request->emp_tar_fecha_asignacion,
            'emp_tar_fecha_entrega' => $request->emp_tar_fecha_entrega,
            'emp_tar_estado_tarea' => $request->emp_tar_estado_tarea,
            'produccion_id_produccion' => $id
        ]);
    
        if (!$empTarea) {
            return response()->json([
                'message' => 'Error al crear el registro de tarea para la producción',
                'status' => 500
            ], 500);
        }
    
        return response()->json([
            'message' => 'Tarea asociada con éxito a la producción',
            'empTarea' => $empTarea,
            'status' => 201
        ], 201);
    }
    
}
