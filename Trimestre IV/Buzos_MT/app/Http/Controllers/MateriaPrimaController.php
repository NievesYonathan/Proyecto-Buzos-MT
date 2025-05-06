<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use App\Models\User;
use App\Models\MateriaPrima;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http; // Importar Http para consumir la API

class MateriaPrimaController extends Controller
{
    public function index()
    {
        $materiaPrima = []; // Inicializar la variable para evitar errores

        try {
            // Llamar a la API para obtener los datos de materia prima
            $response = Http::get('http://localhost:8000/api/materia-prima');

            if ($response->successful()) {
                $materiaPrima = $response->json(); // Convertir la respuesta JSON en un array
            }
        } catch (\Exception $e) {
            // Manejar errores sin romper la vista
        }

        return view("Perfil_Inventario.item-list", compact("materiaPrima"));
    }

    public function show($id)
    {
        return view("Perfil_Inventario.item-detail", compact("id"));
    }

    public function showSearchForm()
    {
        return view('Perfil_Inventario.search-item');
    }

    public function search(Request $request)
    {
        $busqueda = $request->input('busqueda');

        $materiaPrima = MateriaPrima::where('mat_pri_nombre', 'LIKE', '%' . $busqueda . '%')->get();

        return view('Perfil_Inventario.search-item-results', [
            'busqueda' => $busqueda,
            'materiaPrima' => $materiaPrima
        ]);
    }

    public function form_nuevo()
    {
        $estados = Estado::all();
        $proveedores = User::whereHas('cargos', function ($query) {
            $query->where('id_cargos', 4);
        })->get();

        return view("Perfil_Inventario.new-item", compact("estados", "proveedores"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:140',
            'descripcion' => 'nullable|string|max:255',
            'unidad_medida' => 'required|string|max:20',
            'cantidad' => 'required|integer|min:1',
            'estado' => 'required|boolean',
            'fecha_compra' => 'required|date',
            'proveedor_id' => 'required|integer',
        ]);

        try {
            $response = Http::post('http://localhost:8000/api/materia-prima', [
                'mat_pri_nombre' => $request->input('nombre'),
                'mat_pri_descripcion' => $request->input('descripcion'),
                'mat_pri_unidad_medida' => $request->input('unidad_medida'),
                'mat_pri_cantidad' => $request->input('cantidad'),
                'mat_pri_estado' => $request->input('estado'),
                'fecha_compra_mp' => $request->input('fecha_compra'),
                'proveedores_id_proveedores' => $request->input('proveedor_id'),
            ]);

            if ($response->successful()) {
                return redirect()->route('lista-item')->with('success', 'Materia prima creada exitosamente.');
            } else {
                return redirect()->back()->with('error', 'Error al crear materia prima: ' . $response->body());
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Excepción: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $materiaPrima = MateriaPrima::findOrFail($id);
        $estados = Estado::all();
        $proveedores = User::whereHas('cargos', function ($query) {
            $query->where('id_cargos', 4);
        })->get();
    
        // Devolver la vista explícitamente
        return response()->view("Perfil_Inventario.update-item", compact("materiaPrima", "estados", "proveedores"));
    }

    public function delete($id)
    {
        try {
            // Enviar solicitud DELETE a la API
            $response = Http::delete("http://localhost:8000/api/materia-prima/{$id}");

            if ($response->successful()) {
                return redirect()->route('lista-item')->with('success', 'Materia prima eliminada correctamente.');
            }
        } catch (\Exception $e) {
            return redirect()->route('lista-item')->with('error', 'Error al eliminar materia prima.');
        }
    }
}
