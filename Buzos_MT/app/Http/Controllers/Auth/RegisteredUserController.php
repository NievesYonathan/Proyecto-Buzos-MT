<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Seguridad; // Asegúrate de importar el modelo Seguridad
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\TipoDoc;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $tiposDoc = TipoDoc::all();
        return view('auth.register', compact('tiposDoc'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'num_doc' => ['required', 'integer'], // Validar el número de documento
            't_doc' => ['required', 'integer'], // Validar tipo de documento
            'usu_nombres' => ['required', 'string', 'max:60'],
            'usu_apellidos' => ['required', 'string', 'max:45'],
            'usu_email' => ['required', 'string', 'email', 'max:50', 'unique:usuarios'],
            'usu_fecha_nacimiento' => ['required', 'date'],
            'usu_sexo' => ['required', 'string', 'max:1'],
            'usu_direccion' => ['required', 'string', 'max:50'],
            'usu_telefono' => ['required', 'string', 'max:10'],
            'usu_estado' => ['required', 'integer'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Crear el usuario en la tabla usuarios
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

        // Crear el registro en la tabla seguridad
        Seguridad::create([
            'usu_num_doc' => $user->num_doc,
            'seg_clave_hash' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user); // Iniciar sesión automáticamente después del registro

        return redirect(route('dashboard', absolute: false));
    }
}
