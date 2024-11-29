<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\TipoDoc;
use App\Models\Estado;
use App\Models\Seguridad;
use App\Models\Cargo; 
use App\Models\EmpTarea; 
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
        $usuario = User::where('num_doc', $num_doc)->first();

        if (!$usuario) {
            return redirect()->route('user-list')->with('error', 'Usuario no encontrado.');
        }

        $telefono = $request->input('usuario_telefono', null);

        // Actualiza solo los campos que están presentes en el request
        $usuario->update([
            'usu_nombres' => $request->usu_nombres,
            'usu_apellidos' => $request->usu_apellidos,
            'usu_email' => $request->usu_email,
            'usu_telefono' => $request->usu_telefono,
            'usu_fecha_contratacion' => $request->usu_fecha_contratacion,  // Fecha de contratación
            'usu_estado' => $request->usu_estado,  // Estado
        ]);

        return redirect()->route('user-list')->with('success', 'Usuario actualizado correctamente.');
    }

    public function cambiarestado($num_doc)
    {
        // Buscar al usuario por su número de documento
        $usuario = User::where('num_doc', $num_doc)->first();

        if (!$usuario) {
            return redirect()->route('user-list')->with('error', 'Usuario no encontrado.');
        }

        // Cambiar el estado del usuario
        // Si el estado es "Activo" (1), lo cambiamos a "Inactivo" (0) y viceversa
        $nuevoEstado = $usuario->usu_estado == 1 ? 2 : 1;

        $usuario->usu_estado = $nuevoEstado;
        $usuario->save(); // Guardamos los cambios

        return redirect()->route('user-list')->with('success', 'Estado del usuario actualizado correctamente.');
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

    public function mostrarcargos()
    {
        $usuarios = User::with('cargos')->paginate(10); // Trae usuarios con sus cargos
        $cargos = Cargo::all(); // Todos los cargos
        return view('user-list-cargos.mostrarcargos', compact('usuarios', 'cargos'));
    }

    //

}
