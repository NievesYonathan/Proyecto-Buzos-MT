<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produccion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BuzosImageController extends Controller
{
    public function storeImagePro(Request $request, $id)
    {
        $produccion = Produccion::find($id);

        if (!$produccion) {
            $data = [
                'message' => 'Registrto no encontrado',
                'status' => 404
            ];
            return response()->json($data, 404);
        }

        $request->validate([
            'pro_img' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Eliminar imagen anterior si existe
        if ($produccion->pro_img) {
            Storage::delete($produccion->pro_img);
        }

        $path = null;
        if ($request->hasFile('pro_img')) {
            $path = $request->file('pro_img')->store('buzos_images', 'public');
        }
        // Actualizar solo el campo pro_img
        $produccion->pro_img = $path; // Aquí asignamos el nuevo valor
        $produccion->save(); // Guardar los cambios

        $data = [
            'message' => 'Registro actualizado',
            'produccion' => $produccion,
            'url_imagen' => $path ? Storage::url($path) : null,
            'status' => 200
        ];

        //return response()->json($data, 200);

        return redirect()->route('pro_fabricados');
    }

    public function deleteImagePro($id)
    {
        $produccion = Produccion::find($id);

        if (!$produccion) {
            return response()->json([
                'message' => 'Registro no encontrado',
                'status' => 404
            ], 404);
        }

        // Verificar si el produccion tiene una imagen asignada
        if ($produccion->pro_img) {
            // Eliminar el archivo físico del almacenamiento
            if (Storage::disk('public')->exists($produccion->pro_img)) {
                Storage::disk('public')->delete($produccion->pro_img);
            }

            // Limpiar el campo de la imagen en la base de datos
            $produccion->pro_img = null;
            $produccion->save();

            // return response()->json([
            //     'message' => 'Imagen eliminada correctamente',
            //     'status' => 200
            // ], 200);

            return redirect()->route('pro_fabricados');
        }

        // Si no había imagen
        return response()->json([
            'message' => 'No hay imagen para eliminar',
            'status' => 404
        ], 404);
    }


    public function getImage($id)
    {
        $buzos = Produccion::findOrFail($id);
        return response()->json(['path' => Storage::url($buzos->pro_imag)], 200);
    }
}
