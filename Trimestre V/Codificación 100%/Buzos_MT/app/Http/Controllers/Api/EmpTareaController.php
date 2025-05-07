<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmpTarea;
use Illuminate\Support\Facades\Validator;

class EmpTareaController extends Controller
{
    public function store(Request $request, $id)
    {
        // Si es un array JSON
        if ($request->isJson()) {
            $tareasData = $request->json()->all();
            $tareas = [];
            
            foreach ($tareasData as $tareaData) {
                $validator = Validator::make($tareaData, [
                    'empleados_num_doc' => 'required',
                    'tarea_id_tarea' => 'required',
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

                $tarea = EmpTarea::create([
                    'empleados_num_doc' => $tareaData['empleados_num_doc'],
                    'tarea_id_tarea' => $tareaData['tarea_id_tarea'],
                    'emp_tar_fecha_asignacion' => now()->toDateString(),
                    'emp_tar_fecha_entrega' => $tareaData['emp_tar_fecha_entrega'],
                    'emp_tar_estado_tarea' => $tareaData['emp_tar_estado_tarea'],
                    'produccion_id_produccion' => (int)$id
                ]);

                if(!$tarea) {
                    return response()->json([
                        'message' => 'Error al crear el registro de tarea',
                        'status' => 500
                    ], 500);
                }

                $tareas[] = $tarea;
            }

            return response()->json([
                'tareas' => $tareas,
                'status' => 201
            ], 201);
        }

        // Si es form-data (código existente)
        $validator = Validator::make($request->all(), [
            'empleados_num_doc.*' => 'required',
            'tarea_id_tarea.*' => 'required',
            'emp_tar_fecha_entrega.*' => 'required',
            'emp_tar_estado_tarea.*' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $tareas = [];
        
        for ($i = 0; $i < count($request->tarea_id_tarea); $i++) {
            $tarea = EmpTarea::create([
                'empleados_num_doc' => $request->empleados_num_doc[$i],
                'tarea_id_tarea' => $request->tarea_id_tarea[$i],
                'emp_tar_fecha_asignacion' => now()->toDateString(),
                'emp_tar_fecha_entrega' => $request->emp_tar_fecha_entrega[$i],
                'emp_tar_estado_tarea' => $request->emp_tar_estado_tarea,
                'produccion_id_produccion' => (int)$id
            ]);

            if(!$tarea) {
                $data = [
                    'message' => 'Error al crear el registro de tarea',
                    'status' => 500
                ];
                return response()->json($data, 500);
            }

            $tareas[] = $tarea;
        }

        $data = [
            'tareas' => $tareas,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function update(Request $request)
    {
        try {
            // Si es un array JSON
            if ($request->isJson()) {
                $tareasData = $request->json()->all();
                $tareasActualizadas = [];
                
                foreach ($tareasData as $tareaData) {
                    $validator = Validator::make($tareaData, [
                        'id_empleado_tarea' => 'required|exists:emp_tarea,id_empleado_tarea',
                        'empleados_num_doc' => 'required',
                        'tarea_id_tarea' => 'required',
                        'emp_tar_fecha_entrega' => 'required|date',
                        'emp_tar_estado_tarea' => 'nullable|integer'
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            'message' => 'Error en la validación de datos',
                            'errors' => $validator->errors(),
                            'status' => 400
                        ], 400);
                    }

                    $tarea = EmpTarea::findOrFail($tareaData['id_empleado_tarea']);
                    
                    $tarea->update([
                        'empleados_num_doc' => $tareaData['empleados_num_doc'],
                        'tarea_id_tarea' => $tareaData['tarea_id_tarea'],
                        'emp_tar_fecha_entrega' => $tareaData['emp_tar_fecha_entrega'],
                        'emp_tar_estado_tarea' => $tareaData['emp_tar_estado_tarea']
                    ]);

                    $tareasActualizadas[] = $tarea->fresh();
                }

                return response()->json([
                    'message' => 'Tareas actualizadas correctamente',
                    'tareas' => $tareasActualizadas,
                    'status' => 200
                ], 200);
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar las tareas',
                'error' => $e->getMessage(),
                'status' => 500
            ], 500);
        }

        // Si es form-data
        $validator = Validator::make($request->all(), [
            'id_empleado_tarea.*' => 'nullable',
            'empleados_num_doc.*' => 'required',
            'tarea_id_tarea.*' => 'required',
            'emp_tar_fecha_entrega.*' => 'required',
            'emp_tar_estado_tarea.*' => 'nullable',
            'id_produccion' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $tareasActualizadas = [];

        for ($i = 0; $i < count($request->tarea_id_tarea); $i++) {
            // Si existe id_empleado_tarea, actualizar
            if (isset($request->id_empleado_tarea[$i])) {
                $tarea = EmpTarea::find($request->id_empleado_tarea[$i]);

                if (!$tarea) {
                    return response()->json([
                        'message' => 'Tarea no encontrada',
                        'status' => 404
                    ], 404);
                }

                $tarea->empleados_num_doc = $request->empleados_num_doc[$i];
                $tarea->tarea_id_tarea = $request->tarea_id_tarea[$i];
                $tarea->emp_tar_fecha_entrega = $request->emp_tar_fecha_entrega[$i];
                if (isset($request->emp_tar_estado_tarea[$i])) {
                    $tarea->emp_tar_estado_tarea = $request->emp_tar_estado_tarea[$i];
                }
                $tarea->save();
            }
            // Si no existe id_empleado_tarea, crear nuevo
            else {
                $tarea = EmpTarea::create([
                    'empleados_num_doc' => $request->empleados_num_doc[$i],
                    'tarea_id_tarea' => $request->tarea_id_tarea[$i],
                    'emp_tar_fecha_asignacion' => now()->toDateString(),
                    'emp_tar_fecha_entrega' => $request->emp_tar_fecha_entrega[$i],
                    'emp_tar_estado_tarea' => 1,
                    'produccion_id_produccion' => $request->id_produccion
                ]);
            }

            $tareasActualizadas[] = $tarea;
        }

/*         return response()->json([
            'message' => 'Tareas actualizadas correctamente',
            'tareas' => $tareasActualizadas,
            'status' => 200
        ], 200);
 */    

        // Redirigir o retornar una respuesta de éxito
        return redirect()->route('pro_fabricados')->with('success', 'Producción actualizada exitosamente.');

    }

    public function destroy($id)
    {
        $producto = EmpTarea::find($id);

        if(!$producto){
            $data = [
                'message' => 'Registrto no encontrado',
                'status' => 404
            ]; 
            return response()->json($data, 404);
        }

        $producto->delete();

        $data = [
            'message' => 'Registrto eliminado',
            'status' => 200
        ]; 

        return response()->json($data, 200);
    }
}
