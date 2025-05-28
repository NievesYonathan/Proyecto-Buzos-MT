<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class TareaController extends Controller
{
    private $apiBase;

    public function __construct()
    {
        $this->apiBase = 'http://localhost/dash/Proyecto-Buzos-MT/Trimestre IV/API REST/Buzos_MT/public/api';
        Http::timeout(5);
    }

    public function index()
    {
        try {
            $tareas = Http::get("{$this->apiBase}/tareas");
            $estados = Http::get("{$this->apiBase}/estados");

            if (!$tareas->successful() || !$estados->successful()) {
                throw new \Exception("Error al obtener datos");
            }

            return view('Perfil_Produccion.nueva_tarea', [
                'tareas' => $tareas->json(),
                'estados' => $estados->json(),
            ]);
        } catch (\Exception $e) {
            return back()->with('error', 'Error de conexión con el servidor');
        }
    }

    public function store(Request $request)
    {
        try {
            $response = Http::post("{$this->apiBase}/tareas", $request->all());

            if ($response->successful()) {
                return redirect()->route('pro_tareas')->with('success', 'Tarea creada exitosamente.');
            }

            return back()->with('error', 'Error al crear tarea');
        } catch (\Exception $e) {
            return back()->with('error', 'Error de conexión con el servidor');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $response = Http::put("{$this->apiBase}/tareas/{$id}", $request->all());

            if ($response->successful()) {
                return redirect()->back()->with('success', 'Tarea actualizada exitosamente.');
            }

            return back()->with('error', 'Error al actualizar la tarea');
        } catch (\Exception $e) {
            return back()->with('error', 'Error de conexión con el servidor');
        }
    }

    public function tareasAsignadas()
    {
        try {
            $userId = Auth::user()->num_doc;

            $response = Http::get("{$this->apiBase}/tareas-asignadas", [
                'num_doc' => $userId
            ]);

            if ($response->successful()) {
                $data = $response->json();
                return view('Perfil-Operario.tareasAsignadas', [
                    'tareasAsignadas' => $data['tareasAsignadas'] ?? [],
                    'estados' => $data['estados'] ?? []
                ]);
            }

            return back()->with('error', 'Error al obtener tareas asignadas');
        } catch (\Exception $e) {
            return back()->with('error', 'Error de conexión con el servidor');
        }
    }


    public function editarEstado($id_tarea, $id_empleado_tarea)
    {
        try {
            $response = Http::get("{$this->apiBase}/tareas/estado/{$id_tarea}/{$id_empleado_tarea}");

            if ($response->successful()) {
                $data = $response->json();
                return view('Perfil-Operario.editarEstado', $data);
            }

            return back()->with('error', 'Error al cargar la tarea');
        } catch (\Exception $e) {
            return back()->with('error', 'Error de conexión con el servidor');
        }
    }

    public function actualizarEstado(Request $request, $id_tarea, $id_empleado_tarea)
    {
        try {
            $response = Http::put("{$this->apiBase}/tareas/estado/{$id_empleado_tarea}", [
                'estadoTarea' => $request->estadoTarea
            ]);

            if ($response->successful()) {
                return redirect()->route('tarea.editar', [
                    'id_tarea' => $id_tarea,
                    'id_empleado_tarea' => $id_empleado_tarea
                ])->with('success', 'Estado actualizado correctamente');
            }

            return back()->with('error', 'Error al actualizar estado');
        } catch (\Exception $e) {
            return back()->with('error', 'Error de conexión con el servidor');
        }
    }
}
