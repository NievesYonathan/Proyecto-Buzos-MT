<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class BuzosImageController extends Controller
{
    public function uploadImageBuzos(Request $request)
    {
        $request->validate([
            'pro_img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'id_produccion' => 'required|string', // Asegúrate de tener el id_produccion
        ]);
    
        $path = null;
        if ($request->hasFile('pro_img')) {
            $path = $request->file('pro_img')->store('buzos_images', 'public');
        }
    
        // Obtener num_doc desde la solicitud
        $id_produccion = $request->id_produccion;
    
        // Buscar el usuario por id_produccion
        $buzos = Produccion::where('id_produccion', $id_produccion)->first();
    
        // Verificar si el usuario existe
        if ($buzos) {
            // Actualizar solo el campo imag_perfil
            $buzos->pro_img = $path; // Aquí asignamos el nuevo valor
            $buzos->save(); // Guardar los cambios
    
            return redirect()->route('pro_fabricados')->with('success', 'Imagen actualizada con éxito.');
        } else {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
    }
        
    public function getImage($id)
    {
        $buzos = Produccion::findOrFail($id);
        return response()->json(['path' => Storage::url($buzos->pro_imag)], 200);
    }
}
