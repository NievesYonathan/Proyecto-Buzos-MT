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
        return view('Perfil_Inventario.search-item-results', compact('busqueda'));
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
        try {
            // Enviar los datos a la API
            $response = Http::post('http://localhost:8000/api/materia-prima', [
                'nombre' => $request->input('nombre'),
                'cantidad' => $request->input('cantidad'),
                'proveedor_id' => $request->input('proveedor_id'),
            ]);

            if ($response->successful()) {
                return redirect()->to(route('item-list'))->with('success', 'Materia prima agregada correctamente.');
            }
        } catch (\Exception $e) {
            return redirect()->route('item-list')->with('error', 'Error al agregar materia prima.');
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
