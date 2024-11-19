<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserProfileController extends Controller
{
    public function uploadImage(Request $request)
    {
        $request->validate([
            'imag_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'num_doc' => 'required|string', // Asegúrate de tener el num_doc
        ]);
    
        $path = null;
        if ($request->hasFile('imag_perfil')) {
            $path = $request->file('imag_perfil')->store('profile_images', 'public');
        }
    
        // Obtener num_doc desde la solicitud
        $num_doc = $request->num_doc;
    
        // Buscar el usuario por num_doc
        $user = User::where('num_doc', $num_doc)->first();
    
        // Verificar si el usuario existe
        if ($user) {
            // Actualizar solo el campo imag_perfil
            $user->imag_perfil = $path; // Aquí asignamos el nuevo valor
            $user->save(); // Guardar los cambios
    
            return redirect()->route('profile.edit')->with('success', 'Imagen actualizada con éxito.');
        } else {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
    }
        
    public function getImage($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['path' => Storage::url($user->imag_perfil)], 200);
    }
}
