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
        $validator = Validator::make($request->all(), [
        'reg_pmp_cantidad_usada' => 'required',
        'id_pro_materia_prima' => 'required'
        ]);

        if ($validator->fails()){
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $producto = RegProMateriaPrima::create([
            'reg_pmp_cantidad_usada' => $request->reg_pmp_cantidad_usada,
            'reg_pmp_fecha_registro' => now(),
            'id_pro_materia_prima' => $request->id_pro_materia_prima,
            'id_produccion' => $id
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
        $producto = RegProMateriaPrima::find($id);

        if(!$producto){
            $data = [
                'message' => 'Registrto no encontrado',
                'status' => 404
            ]; 
            return response()->json($data, 404);
        }

        $validator = Validator::make($request->all(), [
            'pro_nombre' => 'required',
            'pro_fecha_inicio' => 'required',
            'pro_fecha_fin' => 'required',
            'pro_cantidad' => 'required',
            'pro_etapa' => 'required'
        ]);

        if($validator->fails()){
            $data = [
                'message' => 'Error en la validación de datos',
                'errors' => $validator->errors(),
                'status' => 400
            ];
            return response()->json($data, 400);
        }

        $producto->pro_nombre = $request->pro_nombre;
        $producto->pro_fecha_inicio = $request->pro_fecha_inicio;
        $producto->pro_fecha_fin = $request->pro_fecha_fin;
        $producto->pro_cantidad = $request->pro_cantidad;
        $producto->pro_etapa = $request->pro_etapa;

        $producto->save();

        $data = [
            'message' => 'Registro actualizado',
            'producto' => $producto,
            'status' => 200
        ];
        return response()->json($data, 200);
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
}
