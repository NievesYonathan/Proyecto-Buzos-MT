<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegProMateriaPrima;
use Illuminate\Support\Facades\Validator;

class RegProMateriaPrimaController extends Controller
{
    public function index()
    {
        $producto = RegProMateriaPrima::with(['etapa', 'materiasPrimas', 'tareas'])->get();

        if(!$producto)
        {
            $data = [
                'message' => 'No se encontró RegProMateriaPrimaes.',
                'status' => 200
            ];
            return response()->json($data, 404);
        }

        $data = [
            'producto' => $producto,
            'status' => 200
        ];
    
        return response()->json($data, 200);
    }

    public function show($id)
    {
        $producto = RegProMateriaPrima::with(['etapa', 'materiasPrimas', 'tareas'])->find($id);

        if(!$producto){
            $data = [
                'message' => 'Registro no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $data = [
            'producto' => $producto,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function store(Request $request, $id)
    {
        try {
            // Si es un array JSON
            if ($request->isJson()) {
                $materiasData = $request->json()->all();
                $materias = [];
                
                foreach ($materiasData as $materiaData) {
                    $validator = Validator::make($materiaData, [
                        'reg_pmp_cantidad_usada' => 'required',
                        'id_pro_materia_prima' => 'required'
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            'message' => 'Error en la validación de datos',
                            'errors' => $validator->errors(),
                            'status' => 400
                        ], 400);
                    }

                    $materia = RegProMateriaPrima::create([
                        'reg_pmp_cantidad_usada' => $materiaData['reg_pmp_cantidad_usada'],
                        'reg_pmp_fecha_registro' => now()->toDateString(),
                        'id_pro_materia_prima' => $materiaData['id_pro_materia_prima'],
                        'id_produccion' => (int)$id
                    ]);

                    if(!$materia) {
                        return response()->json([
                            'message' => 'Error al crear el registro de materia prima',
                            'status' => 500
                        ], 500);
                    }

                    $materias[] = $materia;
                }

                return response()->json([
                    'materias' => $materias,
                    'status' => 201
                ], 201);
            }

            // Si es form-data
            $validator = Validator::make($request->all(), [
                'reg_pmp_cantidad_usada.*' => 'required',
                'id_pro_materia_prima.*' => 'required'
            ]);

            if ($validator->fails()){
                return response()->json([
                    'message' => 'Error en la validación de datos',
                    'errors' => $validator->errors(),
                    'status' => 400
                ], 400);
            }

            $materias = [];
            
            for ($i = 0; $i < count($request->id_pro_materia_prima); $i++) {
                $materia = RegProMateriaPrima::create([
                    'reg_pmp_cantidad_usada' => $request->reg_pmp_cantidad_usada[$i],
                    'reg_pmp_fecha_registro' => now()->toDateString(),
                    'id_pro_materia_prima' => $request->id_pro_materia_prima[$i],
                    'id_produccion' => (int)$id
                ]);

                if(!$materia) {
                    return response()->json([
                        'message' => 'Error al crear el registro de materia prima',
                        'status' => 500
                    ], 500);
                }

                $materias[] = $materia;
            }

            return response()->json([
                'materias' => $materias,
                'status' => 201
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al crear los registros',
                'error' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    public function updatePartial(Request $request, $id)
    {
        $producto = RegProMateriaPrima::find($id);

        if(!$producto){
            $data = [
                'message' => 'Registrto no encontrado',
                'status' => 404
            ]; 
            return response()->json($data, 404);
        }

        if ($request->has('pro_nombre')){
            $producto->pro_nombre = $request->pro_nombre;
        }

        if ($request->has('pro_fecha_inicio')){
            $producto->pro_fecha_inicio = $request->pro_fecha_inicio;
        }

        if ($request->has('pro_fecha_fin')){
            $producto->pro_fecha_fin = $request->pro_fecha_fin;
        }

        if ($request->has('pro_cantidad')){
            $producto->pro_cantidad = $request->pro_cantidad;
        }
      
        if ($request->has('pro_etapa')){
            $producto->pro_etapa = $request->pro_etapa;
        }
      
        $producto->save();

        $data = [
            'message' => 'Registro actualizado',
            'producto' => $producto,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $producto = RegProMateriaPrima::find($id);

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

    public function update(Request $request)
    {
        try {
            // Si es form-data
            $validator = Validator::make($request->all(), [
                'id_registro.*' => 'nullable',
                'produccion_mtPrima.*' => 'required',
                'mtPrima_cantidad.*' => 'required',
                'id_produccion' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Error en la validación de datos',
                    'errors' => $validator->errors(),
                    'status' => 400
                ], 400);
            }

            $materiasActualizadas = [];

            for ($i = 0; $i < count($request->produccion_mtPrima); $i++) {
                // Si existe id_registro, actualizar
                if (isset($request->id_registro[$i])) {
                    $materia = RegProMateriaPrima::find($request->id_registro[$i]);

                    if (!$materia) {
                        return response()->json([
                            'message' => 'Materia prima no encontrada',
                            'status' => 404
                        ], 404);
                    }

                    $materia->reg_pmp_cantidad_usada = $request->mtPrima_cantidad[$i];
                    $materia->id_pro_materia_prima = $request->produccion_mtPrima[$i];
                    $materia->save();
                }
                // Si no existe id_registro, crear nuevo
                else {
                    $materia = RegProMateriaPrima::create([
                        'reg_pmp_cantidad_usada' => $request->mtPrima_cantidad[$i],
                        'reg_pmp_fecha_registro' => now()->toDateString(),
                        'id_pro_materia_prima' => $request->produccion_mtPrima[$i],
                        'id_produccion' => $request->id_produccion
                    ]);
                }

                $materiasActualizadas[] = $materia;
            }

            if (!$request->expectsJson()) {
                // Redirigir o retornar una respuesta de éxito
                return redirect()->route('pro_fabricados')->with('success', 'Producción actualizada exitosamente.');
            }

            return response()->json([
                'message' => 'Materias primas actualizadas correctamente',
                'materias' => $materiasActualizadas,
                'status' => 200
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al actualizar las materias primas',
                'error' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }
}
