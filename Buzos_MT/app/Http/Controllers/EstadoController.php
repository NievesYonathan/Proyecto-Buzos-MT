<?php

namespace App\Http\Controllers;

use App\Models\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
public function index()
{
// Obtener todos los estados
$estados = Estado::all();
return view('Perfil-Admin-Usuarios.vistaEstados', compact('estados'));
}

public function crearEstado(Request $request)
{
// Validar y crear un nuevo estado
$request->validate(['nombre_estado' => 'required|string|max:255']);
Estado::create(['nombre_estado' => $request->nombre_estado]);

return redirect()->back()->with('success', 'Estado creado correctamente.');
}

public function actualizarEstado(Request $request, $id)
{
// Validar y actualizar el estado
$request->validate(['nombre_estado' => 'required|string|max:255']);
$estado = Estado::findOrFail($id);
$estado->update(['nombre_estado' => $request->nombre_estado]);

return redirect()->back()->with('success', 'Estado actualizado correctamente.');
}
}