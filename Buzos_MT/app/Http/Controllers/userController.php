<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TipoDoc; 
use App\Models\Estado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index()
    {
        // Obtener todos los usuarios
        $usuarios = User::all();
        $tiposDocumentos = TipoDoc::all();
        $estados = Estado::all();

        return view('Perfil-Admin-Usuarios.user-list', compact('usuarios', 'tiposDocumentos','estados'));
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
            // Validar los datos
            $validated = $request->validate([
                'tipoDocumento' => 'required|integer',
                'numeroDocumento' => 'required|string|max:20',
                'nombres' => 'required|string|max:35',
                'apellidos' => 'required|string|max:35',
                'fechaNacimiento' => 'required|date',
                'sexo' => 'required|in:M,F',
                'direccion' => 'required|string|max:190',
                'celular' => 'required|string|max:20',
                'correo' => 'required|email|max:70',
                'password' => 'required|string|min:8|confirmed',
            ]);
    
            // Crear el nuevo usuario
            $user = new User();
            $user->tipo_documento_id = $request->tipoDocumento;
            $user->numero_documento = $request->numeroDocumento;
            $user->nombres = $request->nombres;
            $user->apellidos = $request->apellidos;
            $user->fecha_nacimiento = $request->fechaNacimiento;
            $user->sexo = $request->sexo;
            $user->direccion = $request->direccion;
            $user->celular = $request->celular;
            $user->correo = $request->correo;
            $user->password = bcrypt($request->password); // Hashear la contraseña
            $user->save();
    
            // Redireccionar con éxito
            return redirect()->route('user-list')->with('alerta', 'Usuario creado con éxito.');
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
