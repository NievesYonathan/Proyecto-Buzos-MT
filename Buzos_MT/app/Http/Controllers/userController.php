<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TipoDoc;
use App\Models\Estado;
use App\Models\Seguridad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function index()
    {
        // Obtener todos los usuarios
        $usuarios = User::all();
        $tiposDocumentos = TipoDoc::all();
        $estados = Estado::all();

        return view('Perfil-Admin-Usuarios.user-list', compact('usuarios', 'tiposDocumentos', 'estados'));
    }

    public function create()
    {
        // Obtener tipos de documentos
        $tipos_documentos = TipoDoc::all();
        return view('Perfil-Admin-Usuarios.user-new', compact('tipos_documentos'));
    }

    // Almacena los datos del usuario
    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'num_doc' => ['required', 'integer'], // Validar el número de documento
            't_doc' => ['required', 'integer'], // Validar tipo de documento
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

        // Crear un nuevo usuario
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
            'usu_fecha_contratacion' => now(), // Asignar la fecha de contratación actual
        ]);

        Seguridad::create([
            'usu_num_doc' => $request->num_doc,
            'seg_clave_hash' => Hash::make($request->password),
        ]);

        // Redirigir con mensaje de éxito
        return redirect()->route('user-list')->with('alerta', 'Usuario creado con éxito');
    }


    public function update(Request $request, $num_doc)
    {
        // Aquí actualizas los datos de un usuario
        $usuario = User::where('num_doc', $num_doc)->first();
        $usuario->update($request->all());

        return redirect()->route('user-list')->with('success', 'Usuario actualizado correctamente.');
    }

    public function destroy($num_doc)
    {
        // Eliminar el usuario
        User::where('num_doc', $num_doc)->delete();
        return redirect()->route('user-list')->with('success', 'Usuario eliminado correctamente.');
    }

    public function buscar(Request $request)
    {
        $search = $request->input('search', '');  // Obtener el término de búsqueda
        $resultado = null;

        if ($search) {
            // Buscar los usuarios que coinciden con el término de búsqueda
            $resultado = User::where('usu_nombres', 'LIKE', "%$search%")
                ->orWhere('usu_apellidos', 'LIKE', "%$search%")
                ->orWhere('num_doc', 'LIKE', "%$search%")
                ->get();

            // Si no se encuentran resultados
            if ($resultado->isEmpty()) {
                Session::flash('alerta', "No se encontraron resultados para '$search'.");
            } else {
                Session::flash('alerta', "Búsqueda realizada para '$search'.");
            }
        } else {
            Session::flash('alerta', "Por favor, ingrese un término de búsqueda.");
        }

        // Retornar la vista con los resultados
        return view('Perfil-Admin-Usuarios.user-search', compact('search', 'resultado'));
    }

    public function mostrarFormulario()
    {
        $usuario = User::where('num_doc', Auth::user()->num_doc)->first();
        $tiposDocumento = TipoDoc::all();

        return view('actualizar-usuario', compact('usuario', 'tiposDocumento'));
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'usuario_nombre' => 'required|string|max:35',
            'usuario_apellido' => 'required|string|max:35',
            'usuario_telefono' => 'required|string|max:15',
            'usuario_email' => 'required|email|max:70',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $usuario = User::where('num_doc', Auth::user()->num_doc)->first();
        $usuario->nombres = $request->input('usu_nombres');
        $usuario->apellidos = $request->input('usu_apellidos');
        $usuario->telefono = $request->input('usu_telefono');
        $usuario->email = $request->input('usu_email');
        $usuario->sexo = $request->input('usu_sexo');

        if ($request->filled('password')) {
            $usuario->password = bcrypt($request->input('password'));
        }

        $usuario->save();

        return redirect()->route('usuario.formulario')->with('success', 'Datos actualizados correctamente.');
    }
}
