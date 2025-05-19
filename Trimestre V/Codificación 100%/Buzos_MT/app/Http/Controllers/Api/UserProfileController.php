<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class UserProfileController extends Controller
{
    public function storeImage(Request $request, $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            $data = [
                'message' => 'Registrto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $request->validate([
            'imag_perfil' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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
        
        //return response()->json($data, 200);

        return redirect()->route('profile.edit');
    }

    public function updateImage(Request $request, $id)
    {
        $usuario = User::find($id);

        if (!$usuario) {
            $data = [
                'message' => 'Registrto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $request->validate([
            'imag_perfil' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
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

    public function getImage($id)
    {
        $user = User::findOrFail($id);
        return response()->json(['path' => Storage::url($user->imag_perfil)], 200);
    }

    public function deleteImage($id)
    {
        // Buscar al usuario por su ID
        $usuario = User::find($id);

        if (!$usuario) {
            return response()->json([
                'message' => 'Registro no encontrado',
                'status' => 404
            ], 404);
        }

        // Verificar si el usuario tiene una imagen asignada
        if ($usuario->imag_perfil) {
            // Eliminar el archivo físico del almacenamiento
            if (Storage::disk('public')->exists($usuario->imag_perfil)) {
                Storage::disk('public')->delete($usuario->imag_perfil);
            }

            // Limpiar el campo de la imagen en la base de datos
            $usuario->imag_perfil = null;
            $usuario->save();

            // return response()->json([
            //     'message' => 'Imagen eliminada correctamente',
            //     'status' => 200
            // ], 200);

            return redirect()->route('profile.edit');
        }

        // Si no había imagen
        return response()->json([
            'message' => 'No hay imagen para eliminar',
            'status' => 404
        ], 404);
    }
}
