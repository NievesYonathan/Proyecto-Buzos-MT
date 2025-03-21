<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Modelo de Usuario
use App\Models\Cargo;   // Modelo de Cargo

class ListaCargoController extends Controller
{
    /**
     * Muestra la lista de usuarios con sus cargos.
     */
    public function index()
    {
        // Obtener todos los usuarios con sus cargos relacionados
        $usuarios = User::with('cargos')->paginate(10);

        // Obtener todos los cargos disponibles
        $cargos = Cargo::all();

        // Retornar la vista con los datos
        return view('Perfil-Admin-Usuarios.user-list-cargo', compact('usuarios', 'cargos'));
    }

    /**
     * Almacena los cargos seleccionados para un usuario específico.
     */
    public function store(Request $request)
    {
        // Validar los datos recibidos
        $request->validate([
            'numDoc' => 'required|exists:usuarios,num_doc', // Validar que el usuario exista
            'idCargo' => 'required|array|size:1',          // Validar que solo se seleccione un cargo
            'idCargo.*' => 'exists:cargos,id_cargos',      // Validar que el cargo exista
        ]);

        // Buscar al usuario por su número de documento
        $usuario = User::where('num_doc', $request->numDoc)->firstOrFail();

        // Preparar el cargo con la fecha de asignación y estado asignación
        $cargoConDatos = [
            $request->idCargo[0] => [
                'fecha_asignacion' => now(),
                'estado_asignacion' => 1, // Asignamos el ID 1 (activo)
            ],
        ];

        // Asignar el cargo, reemplazando cualquier existente
        $usuario->cargos()->sync($cargoConDatos);

        // Redirigir con un mensaje de éxito
        return redirect()->route('user-list-cargo')->with('success', 'Cargo asignado correctamente.');
    }
}
