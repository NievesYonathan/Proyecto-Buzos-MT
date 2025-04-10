<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\TipoDoc;
use App\Models\Estado;
use App\Models\Seguridad;
use App\Models\Cargo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserApiController extends Controller
{
    public function index()
    {
        $usuarios = User::all();
        return response()->json($usuarios);
    }

    public function store(Request $request)
    {
        $request->validate([
            'num_doc' => ['required', 'integer'],
            't_doc' => ['required', 'integer'],
            'usu_nombres' => ['required', 'string', 'max:60'],
            'usu_apellidos' => ['required', 'string', 'max:45'],
            'usu_email' => ['required', 'string', 'email', 'max:50', 'unique:usuarios'],
            'usu_fecha_nacimiento' => ['required', 'date'],
            'usu_sexo' => ['required', 'string', 'max:1'],
            'usu_telefono' => ['required', 'string', 'max:10'],
            'usu_direccion' => ['required', 'string', 'max:50'],
            'usu_estado' => ['required', 'integer'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'num_doc' => $request->num_doc,
            't_doc' => $request->t_doc,
            'usu_nombres' => $request->usu_nombres,
            'usu_apellidos' => $request->usu_apellidos,
            'usu_email' => $request->usu_email,
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

        return response()->json(['mensaje' => 'Usuario creado con éxito', 'usuario' => $user], 201);
    }

    public function update(Request $request, $num_doc)
    {
        $usuario = User::where('num_doc', $num_doc)->first();

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $usuario->update([
            'usu_nombres' => $request->usu_nombres,
            'usu_apellidos' => $request->usu_apellidos,
            'usu_email' => $request->usu_email,
            'usu_telefono' => $request->usu_telefono,
            'usu_fecha_contratacion' => $request->usu_fecha_contratacion,
            'usu_estado' => $request->usu_estado,
        ]);

        return response()->json(['mensaje' => 'Usuario actualizado correctamente']);
    }

    public function cambiarEstado($num_doc)
    {
        $usuario = User::where('num_doc', $num_doc)->first();

        if (!$usuario) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }

        $usuario->usu_estado = $usuario->usu_estado == 1 ? 2 : 1;
        $usuario->save();

        return response()->json(['mensaje' => 'Estado del usuario actualizado']);
    }

    public function buscar(Request $request)
    {
        $search = $request->query('query', '');

        if (!$search) {
            return response()->json(['mensaje' => 'Debe proporcionar un término de búsqueda'], 400);
        }

        $resultado = User::where('usu_nombres', 'LIKE', "%$search%")
            ->orWhere('usu_apellidos', 'LIKE', "%$search%")
            ->orWhere('num_doc', 'LIKE', "%$search%")
            ->get();

        return response()->json(['resultado' => $resultado]);
    }

    public function mostrarConCargos()
    {
        $usuarios = User::with('cargos')->get();
        return response()->json(['usuarios' => $usuarios]);
    }
}

