<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Seguridad;
use App\Models\TipoDoc;
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;

class UserApiController extends Controller
{
    public function index()
    {
        try {
            $usuarios = User::with(['tipoDocumento:id_tipo_documento,tip_doc_descripcion', 'estado:id_estados,nombre_estado'])->get();
            return response()->json($usuarios);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener usuarios'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'num_doc' => ['required', 'integer', 'unique:usuarios'],
                't_doc' => ['required', 'integer', 'exists:tipo_doc,id_tipo_documento'],
                'usu_nombres' => ['required', 'string', 'max:60'],
                'usu_apellidos' => ['required', 'string', 'max:45'],
                'email' => ['required', 'string', 'email', 'max:50', 'unique:usuarios'],
                'usu_fecha_nacimiento' => ['required', 'date'],
                'usu_sexo' => ['required', 'string', 'max:1'],
                'usu_telefono' => ['required', 'string', 'max:10'],
                'usu_direccion' => ['required', 'string', 'max:50'],
                'usu_estado' => ['required', 'integer'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);

            DB::beginTransaction();
            
            $user = User::create([
                'num_doc' => $request->num_doc,
                't_doc' => $request->t_doc,
                'usu_nombres' => $request->usu_nombres,
                'usu_apellidos' => $request->usu_apellidos,
                'email' => $request->email,
                'usu_fecha_nacimiento' => $request->usu_fecha_nacimiento,
                'usu_sexo' => $request->usu_sexo,
                'usu_direccion' => $request->usu_direccion,
                'usu_telefono' => $request->usu_telefono,
                'usu_estado' => $request->usu_estado,
                'usu_fecha_contratacion' => now(),
            ]);

            Seguridad::create([
                'usu_num_doc' => $request->num_doc,
                'seg_clave_hash' => Hash::make($request->password),
            ]);

            DB::commit();
            return response()->json(['message' => 'Usuario creado exitosamente', 'user' => $user]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $num_doc)
    {
        try {
            $usuario = User::where('num_doc', $num_doc)->first();
            if (!$usuario) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }

            $usuario->update($request->all());
            return response()->json(['message' => 'Usuario actualizado exitosamente', 'user' => $usuario]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function cambiarEstado($num_doc)
    {
        try {
            $usuario = User::where('num_doc', $num_doc)->first();
            if (!$usuario) {
                return response()->json(['error' => 'Usuario no encontrado'], 404);
            }

            $usuario->usu_estado = $usuario->usu_estado == 1 ? 2 : 1;
            $usuario->save();

            return response()->json(['message' => 'Estado actualizado exitosamente', 'user' => $usuario]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function buscar(Request $request)
    {
        try {
            $search = $request->input('search', '');
            $usuarios = User::with(['tipoDocumento:id_tipo_documento,tip_doc_descripcion'])
                ->where('usu_nombres', 'LIKE', "%$search%")
                ->orWhere('usu_apellidos', 'LIKE', "%$search%")
                ->orWhere('num_doc', 'LIKE', "%$search%")
                ->get();

            return response()->json($usuarios);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getTiposDocumentos()
    {
        try {
            $tipos = TipoDoc::all();
            return response()->json($tipos);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener tipos de documentos'], 500);
        }
    }

    public function getEstados()
    {
        try {
            $estados = Estado::all();
            return response()->json($estados);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener estados'], 500);
        }
    }
}