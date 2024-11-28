<?php

namespace App\Http\Controllers;

use App\Models\Cargo;

use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function index()
    {
        // Obtener todos los estados
        $cargos = Cargo::all();
        return view('Perfil-Admin-Usuarios.user-list-cargo', compact('cargos'));
    }

    public function crearCargo(Request $request)
    {
        // Validar y crear un nuevo estado
        $request->validate(['car_nombre' => 'required|string|max:255']);
        Cargo::create(['car_nombre' => $request->car_nombre]);

        return redirect()->back()->with('success', 'Cargo creado correctamente.');
    }


    public function store(Request $request)
    {
        // Validar los datos antes de almacenarlos
        $validated = $request->validate([
            'Car_nombre' => 'required|string|max:255',  // Validación del campo nombre

        ]);

        // Crear un nuevo tipo de documento
        $cargos = new Cargo();
        $cargos->car_nombre = $validated['car_nombre'];


        // Guardar en la base de datos
        $cargos->save();

        // Redirigir o devolver una respuesta (puede ser JSON, o redirigir a la lista)
        return redirect()->route('user-list-cargo')->with('success', 'Cargo creado correctamente');
    }

    public function update(Request $request, $id_cargos)
    {
        $cargos = Cargo::where('id_cargo', $id_cargos)->first();


        // Actualiza solo los campos que están presentes en el request
        $cargos->update([
            'car_nombre' => $request->car_nombre,

        ]);

        return redirect()->route('user-list-cargo')->with('success', 'Cargo actualizada correctamente.');
    }
}
