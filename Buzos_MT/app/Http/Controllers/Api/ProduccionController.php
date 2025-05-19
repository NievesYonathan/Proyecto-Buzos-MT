<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProduccionController extends Controller
{
    public function index()
    {
        $producto = Produccion::with(['etapa', 'materiasPrimas', 'tareas'])->get();

        if(!$producto)
        {
            $data = [
                'message' => 'No se encontró producciones.',
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
        $producto = Produccion::with(['etapa', 'materiasPrimas', 'tareas'])->find($id);

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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'pro_nombre' => 'required',
        'pro_fecha_inicio' => 'required',
        'pro_fecha_fin' => 'required',
        'pro_cantidad' => 'required',
        'pro_etapa' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $producto = Produccion::create([
            'pro_nombre' => $request->pro_nombre,
            'pro_fecha_inicio' => $request->pro_fecha_inicio,
            'pro_fecha_fin' => $request->pro_fecha_fin,
            'pro_cantidad' => $request->pro_cantidad,
            'pro_etapa' => $request->pro_etapa
        ]);

        if(!$producto){
            $data = [
                'message' => 'Error al crear el registro',
                'status' => 500
            ];
            return response()->json($data, 500);
        }

        $data = [
            'producto' => $producto,
            'status' => 201
        ];

        return response()->json($data, 201);
    }

    public function update(Request $request, $id)
    {
        $producto = Produccion::find($id);

        if(!$producto){
            $data = [
                'message' => 'Registrto no encontrado',
                'status' => 404
            ]; 
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'produccion_nombre' => 'required',
            'produccion_fecha_fin' => 'required',
            'produccion_cantidad' => 'required',
            'produccion_etapa' => 'required'
        ]);

        if($validator->fails()){
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $producto->pro_nombre = $request->produccion_nombre;
        $producto->pro_fecha_fin = $request->produccion_fecha_fin;
        $producto->pro_cantidad = $request->produccion_cantidad;
        $producto->pro_etapa = $request->produccion_etapa;

        $producto->save();

        $data = [
            'message' => 'Registro actualizado',
            'producto' => $producto,
            'status' => 200
        ];
        
        if (!$request->expectsJson()) {
            // Redirigir o retornar una respuesta de éxito
            return redirect()->route('pro_fabricados')->with('success', 'Producción actualizada exitosamente.');
        }

        return response()->json($data, 200);
    }

    public function updatePartial(Request $request, $id)
    {
        $producto = Produccion::find($id);

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
        $producto = Produccion::find($id);

        if(!$producto){
            $data = [
                'message' => 'Registrto no encontrado',
                'status' => 404
            ]; 
            return response()->json($data, 404);
        }

        $producto->delete();

        $data = [
            'message' => 'Producción eliminada correctamente',
            'status' => 200
        ]; 

        return response()->json($data, 200);
    }

}
