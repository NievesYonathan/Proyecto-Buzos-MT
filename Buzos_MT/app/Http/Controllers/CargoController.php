<?php

namespace App\Http\Controllers;

use App\Models\Cargo;
use App\Models\User;

use Illuminate\Http\Request;

class CargoController extends Controller
{
    public function index()
    {
        // Obtener todos los estados
        $cargos = Cargo::with('usuarios')->paginate(10);
        return view('Perfil-Admin-Usuarios.cargos', compact('cargos'));
    }

    public function create(Request $request)
    {
        $cargos = Cargo::all();
        // Aquí podrías retornar la vista donde se muestra el formulario.
        return view('cargos');
    }


    public function store(Request $request)
    {
        
        $usuarios = User::findOrFail($request->num_doc);
        // Asignar cargos al usuario
        $usuarios->cargos()->sync($request->id_Cargo);
        return redirect()->route('user-list-cargo.mostrarformulario')->with('success', 'Cargos asignados con éxito');

        // Validar los datos antes de almacenarlos
        $validated = $request->validate([
            'car_nombre' => 'required|string|max:255',  // Validación del campo nombre


        ]);

        // Crear un nuevo tipo de documento
        $cargos = new Cargo();
        $cargos->car_nombre = $validated['car_nombre'];


        // Guardar en la base de datos
        $cargos->save();

        // Redirigir o devolver una respuesta (puede ser JSON, o redirigir a la lista)
        return redirect()->route('cargos')->with('success', 'Cargo creado correctamente');
    }

    public function update(Request $request, $id_cargos)
    {
        $cargos = Cargo::where('id_cargos', $id_cargos)->first();


        // Actualiza solo los campos que están presentes en el request
        $cargos->update([
            'car_nombre' => $request->car_nombre,

        ]);

        return redirect()->route('cargos')->with('success', 'Cargo actualizada correctamente.');
    }
}
