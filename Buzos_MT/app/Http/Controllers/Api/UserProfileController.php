<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserProfileController extends Controller
{
    public function uploadImage(Request $request, $id)
    {
        $usuario = User::find($id);

        if(!$usuario){
            $data = [
                'message' => 'Registrto no encontrado',
                'status' => 404
            ]; 
            return response()->json($data, 404);
        }

        $request->validate([
            'imag_perfil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Eliminar imagen anterior si existe
        if ($usuario->imag_perfil) {
            Storage::delete($usuario->imag_perfil);
        }

        $path = null;
        if ($request->hasFile('imag_perfil')) {
            $path = $request->file('imag_perfil')->store('profile_images', 'public');

        }
        // Actualizar solo el campo imag_perfil
        $usuario->imag_perfil = $path; // Aquí asignamos el nuevo valor
        $usuario->save(); // Guardar los cambios

        $data = [
            'message' => 'Registro actualizado',
            'usuario' => $usuario,
            'url_imagen' => $path ? Storage::url($path) : null,
            'status' => 200
        ];
        return response()->json($data, 200);
    }

    // public function uploadImage(Request $request, $id)
    // {
    //     if ($request->imag_perfil) {
    //         $file = $request->file('imag_perfil');
    //         return response()->json([
    //             'message' => 'Archivo recibido',
    //             'nombre_original' => $file->getClientOriginalName(),
    //             'tamaño' => $file->getSize(),
    //             'mime_type' => $file->getMimeType(),
    //         ], 200);
    //     }

    //     return response()->json(['message' => 'No se recibió ningún archivo'], 400);
    // }

    public function getImage($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['path' => Storage::url($user->imag_perfil)], 200);
    }
}
