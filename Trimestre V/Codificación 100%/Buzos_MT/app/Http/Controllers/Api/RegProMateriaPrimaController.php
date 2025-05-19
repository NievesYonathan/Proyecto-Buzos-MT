<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RegProMateriaPrima;
use Illuminate\Support\Facades\Validator;
use App\Models\MateriaPrima; // Agregar al inicio del archivo

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

                    // Buscar la materia prima y actualizar su cantidad
                    $materiaPrima = MateriaPrima::find($materiaData['id_pro_materia_prima']);
                    if (!$materiaPrima || $materiaPrima->mat_pri_cantidad < $materiaData['reg_pmp_cantidad_usada']) {
                        return response()->json([
                            'message' => 'No hay suficiente cantidad de materia prima disponible',
                            'status' => 400
                        ], 400);
                    }

                    // Crear el registro de uso
                    $materia = RegProMateriaPrima::create([
                        'reg_pmp_cantidad_usada' => $materiaData['reg_pmp_cantidad_usada'],
                        'reg_pmp_fecha_registro' => now()->toDateString(),
                        'id_pro_materia_prima' => $materiaData['id_pro_materia_prima'],
                        'id_produccion' => (int)$id
                    ]);

                    // Actualizar la cantidad en materia_prima
                    $materiaPrima->mat_pri_cantidad -= $materiaData['reg_pmp_cantidad_usada'];
                    $materiaPrima->save();

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
                // Buscar la materia prima y verificar cantidad
                $materiaPrima = MateriaPrima::find($request->id_pro_materia_prima[$i]);
                if (!$materiaPrima || $materiaPrima->mat_pri_cantidad < $request->reg_pmp_cantidad_usada[$i]) {
                    return response()->json([
                        'message' => 'No hay suficiente cantidad de materia prima disponible',
                        'status' => 400
                    ], 400);
                }

                $materia = RegProMateriaPrima::create([
                    'reg_pmp_cantidad_usada' => $request->reg_pmp_cantidad_usada[$i],
                    'reg_pmp_fecha_registro' => now()->toDateString(),
                    'id_pro_materia_prima' => $request->id_pro_materia_prima[$i],
                    'id_produccion' => (int)$id
                ]);

                // Actualizar la cantidad en materia_prima
                $materiaPrima->mat_pri_cantidad -= $request->reg_pmp_cantidad_usada[$i];
                $materiaPrima->save();

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
        $registro = RegProMateriaPrima::find($id);

        if(!$registro){
            return response()->json([
                'message' => 'Registro no encontrado',
                'status' => 404
            ], 404);
        }

        try {
            // Obtener la materia prima asociada
            $materiaPrima = MateriaPrima::find($registro->id_pro_materia_prima);
            
            if ($materiaPrima) {
                // Devolver la cantidad al stock
                $materiaPrima->mat_pri_cantidad += $registro->reg_pmp_cantidad_usada;
                $materiaPrima->save();
            }

            $registro->delete();

            return response()->json([
                'message' => 'Registro eliminado y stock actualizado',
                'status' => 200
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al eliminar el registro',
                'error' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            // Si es un array JSON
            if ($request->isJson()) {
                $materiasData = $request->json()->all();
                $materiasActualizadas = [];

                foreach ($materiasData as $materiaData) {
                    $validator = Validator::make($materiaData, [
                        'id_registro' => 'nullable',
                        'produccion_mtPrima' => 'required',
                        'mtPrima_cantidad' => 'required',
                        'id_produccion' => 'required'
                    ]);

                    if ($validator->fails()) {
                        return response()->json([
                            'message' => 'Error en la validación de datos',
                            'errors' => $validator->errors(),
                            'status' => 400
                        ], 400);
                    }

                    if (isset($materiaData['id_registro'])) {
                        $materia = RegProMateriaPrima::find($materiaData['id_registro']);
                        $materiaPrima = MateriaPrima::find($materiaData['produccion_mtPrima']);

                        if (!$materia || !$materiaPrima) {
                            return response()->json([
                                'message' => 'Materia prima no encontrada',
                                'status' => 404
                            ], 404);
                        }

                        // Calcular la diferencia de cantidad
                        $diferencia = $materiaData['mtPrima_cantidad'] - $materia->reg_pmp_cantidad_usada;
                        
                        if ($diferencia > 0 && $materiaPrima->mat_pri_cantidad < $diferencia) {
                            return response()->json([
                                'message' => 'No hay suficiente cantidad de materia prima disponible',
                                'status' => 400
                            ], 400);
                        }

                        $materiaPrima->mat_pri_cantidad -= $diferencia;
                        $materiaPrima->save();

                        $materia->reg_pmp_cantidad_usada = $materiaData['mtPrima_cantidad'];
                        $materia->id_pro_materia_prima = $materiaData['produccion_mtPrima'];
                        $materia->save();
                    } else {
                        $materiaPrima = MateriaPrima::find($materiaData['produccion_mtPrima']);
                        
                        if (!$materiaPrima || $materiaPrima->mat_pri_cantidad < $materiaData['mtPrima_cantidad']) {
                            return response()->json([
                                'message' => 'No hay suficiente cantidad de materia prima disponible',
                                'status' => 400
                            ], 400);
                        }

                        $materia = RegProMateriaPrima::create([
                            'reg_pmp_cantidad_usada' => $materiaData['mtPrima_cantidad'],
                            'reg_pmp_fecha_registro' => now()->toDateString(),
                            'id_pro_materia_prima' => $materiaData['produccion_mtPrima'],
                            'id_produccion' => $materiaData['id_produccion']
                        ]);

                        $materiaPrima->mat_pri_cantidad -= $materiaData['mtPrima_cantidad'];
                        $materiaPrima->save();
                    }

                    $materiasActualizadas[] = $materia;
                }

                return response()->json([
                    'message' => 'Materias primas actualizadas correctamente',
                    'materias' => $materiasActualizadas,
                    'status' => 200
                ], 200);
            }

            // Si es form-data (código existente)
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
