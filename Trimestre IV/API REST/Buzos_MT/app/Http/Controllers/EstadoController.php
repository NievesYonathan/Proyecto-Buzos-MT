<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class EstadoController extends Controller
{
    private $apiBase;

    public function __construct()
    {
        // Configuración de la API base
        $this->apiBase = 'http://localhost/dash/Proyecto-Buzos-MT/Trimestre IV/API REST/Buzos_MT/public/api';
    }

    // Obtener todos los estados
    public function index()
    {
        try {
            // Llamada a la API para obtener los estados
            $response = Http::get("{$this->apiBase}/estados");

            // Verifica si la respuesta fue exitosa
            if (!$response->successful()) {
                throw new \Exception('Error al obtener los estados');
            }

            // Redirige a la vista 'vistaEstados' pasando los estados obtenidos
            return view('Perfil-Admin-Usuarios.vistaEstados', [
                'estados' => $response->json()
            ]);
        } catch (\Exception $e) {
            // En caso de error, redirige hacia la vista con un mensaje de error
            return back()->with('error', 'Error de conexión con el servidor');
        }
    }

    // Crear un nuevo estado
    public function store(Request $request)
    {
        try {
            // Validar los datos de entrada
            $validated = $request->validate([
                'nombre_estado' => 'required|string|max:255',
            ]);

            // Crear un nuevo estado
            Estado::create([
                'nombre_estado' => $validated['nombre_estado'],
            ]);

            // Después de crear el estado, redirige a 'vistaEstados' con un mensaje de éxito
            return redirect()->route('vistaEstados')->with('success', 'Estado creado con éxito');
        } catch (\Exception $e) {
            // En caso de error, redirige hacia la vista con un mensaje de error
            return back()->with('error', 'Error al crear el estado');
        }
    }

    // Actualizar un estado
    public function update(Request $request, $id_estados)
    {
        try {
            // Buscar el estado por ID
            $estado = Estado::find($id_estados);

            if (!$estado) {
                return redirect()->route('vistaEstados')->with('error', 'Estado no encontrado');
            }

            // Validar los datos de entrada
            $validated = $request->validate([
                'nombre_estado' => 'required|string|max:255',
            ]);

            // Actualizar el estado
            $estado->update([
                'nombre_estado' => $validated['nombre_estado'],
            ]);

            // Después de actualizar el estado, redirige a 'vistaEstados' con un mensaje de éxito
            return redirect()->route('vistaEstados')->with('success', 'Estado actualizado correctamente');
        } catch (\Exception $e) {
            // En caso de error, redirige hacia la vista con un mensaje de error
            return back()->with('error', 'Error al actualizar el estado');
        }
    }

    // Eliminar un estado
    public function destroy($id_estados)
    {
        try {
            
            $estado = Estado::find($id_estados);

            if (!$estado) {
                return redirect()->route('vistaEstados')->with('error', 'Estado no encontrado');
            }

            // Eliminar el estado
            $estado->delete();

            // Después de eliminar el estado, redirige a 'vistaEstados' con un mensaje de éxito
            return redirect()->route('vistaEstados')->with('success', 'Estado eliminado correctamente');
        } catch (\Exception $e) {
            // En caso de error, redirige hacia la vista con un mensaje de error
            return back()->with('error', 'Error al eliminar el estado');
        }
    }
}
