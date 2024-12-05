<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\MateriaPrima;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

class MateriaPrimaController extends Controller
{
    public function index(){
        $materiaPrima = MateriaPrima::all();

        return view("Perfil_Inventario.item-list", compact("materiaPrima"));
    }
    public function form_nuevo()
    {
        $estados = Estado::all();

        $proveedores = User::whereHas('cargos', function ($query) {
            $query->where('id_cargos', 4);
        })->get();

        return view("Perfil_Inventario.new-item", compact("estados","proveedores"));
    }

    public function store(Request $request)
    {
        // Validar los datos
        $validator = Validator::make($request->all(), [
            "mat_pri_nombre" => "required",
            "mat_pri_descripcion" => "required",
            "mat_pri_unidad_medida" => "required",
            "mat_pri_cantidad" => "required|integer|min:1",
            "mat_pri_estado" => "required",
            "fecha_compra_mp" => "required|date",
            "proveedores_id_proveedores" => "required|integer"
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 422
            ], 422);
        }
    
        // Crear el registro
        try {
            $materiaPrima = MateriaPrima::create([
                'mat_pri_nombre' => $request->mat_pri_nombre,
                'mat_pri_descripcion' => $request->mat_pri_descripcion,
                'mat_pri_unidad_medida' => $request->mat_pri_unidad_medida,
                'mat_pri_cantidad' => $request->mat_pri_cantidad,
                'mat_pri_estado' => $request->mat_pri_estado,
                'fecha_compra_mp' => $request->fecha_compra_mp,
                'proveedores_id_proveedores' => $request->proveedores_id_proveedores
            ]);
    
            // return response()->json([
            //     'message' => 'Registro creado exitosamente',
            //     'data' => $materiaPrima,
            //     'status' => 201
            // ], 201);

            return redirect()->route('lista-item');
    
        } catch (\Exception $e) {
            // Manejar errores
            return response()->json([
                'message' => 'Error al crear el registro',
                'error' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }

    public function edit ($id)
    {
        $materiaPrima = MateriaPrima::findOrFail($id);

        $estados = Estado::all();

        $proveedores = User::whereHas('cargos', function ($query) {
            $query->where('id_cargos', 4);
        })->get();

        return view("Perfil_Inventario.update-item", compact("estados","proveedores", "materiaPrima"));
    }

    public function update(Request $request, $id)
    {
        $materiaPrima = MateriaPrima::findOrFail($id);

        if (!$materiaPrima) {
            $data = [
                'message' => 'Registrto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        // Validar los datos
        $validator = Validator::make($request->all(), [
            "mat_pri_nombre" => "required",
            "mat_pri_descripcion" => "required",
            "mat_pri_unidad_medida" => "required",
            "mat_pri_cantidad" => "required|integer|min:1",
            "mat_pri_estado" => "required",
            "fecha_compra_mp" => "required|date",
            "proveedores_id_proveedores" => "required|integer"
        ]);
    
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'status' => 422
            ], 422);
        }
    
        // Crear el registro
        try {
            $materiaPrima->mat_pri_nombre = $request->mat_pri_nombre;
            $materiaPrima->mat_pri_descripcion = $request->mat_pri_descripcion;
            $materiaPrima->mat_pri_unidad_medida = $request->mat_pri_unidad_medida;
            $materiaPrima->mat_pri_cantidad = $request->mat_pri_cantidad;
            $materiaPrima->mat_pri_estado = $request->mat_pri_estado;
            $materiaPrima->fecha_compra_mp = $request->fecha_compra_mp;
            $materiaPrima->proveedores_id_proveedores = $request->proveedores_id_proveedores;
    
            $materiaPrima->save();

            return response()->json([
                'message' => 'Registro actualizado',
                'data' => $materiaPrima,
                'status' => 200
            ], 200);

            // return redirect()->route('lista-item');
    
        } catch (\Exception $e) {
            // Manejar errores
            return response()->json([
                'message' => 'Error al crear el registro',
                'error' => $e->getMessage(),
                'status' => 500
            ], 500);
        }
    }
}
