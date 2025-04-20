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
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();

        $userExists = User::where('external_id', $googleUser->id)->where('external_auth', 'google')->first();

        if ($userExists) {
            Auth::login($userExists);
            return redirect(route('dashboard', absolute: false));
        }

        // Almacena los datos en la sesión temporalmente
        Session::put('googleUser', [
            'name' => $googleUser->name,
            'email' => $googleUser->email,
            'id' => $googleUser->id,
            'avatar' => $googleUser->avatar,
        ]);

        return redirect()->route('register');
    }

    public function create(): View
    {
        $tiposDoc = TipoDoc::all();
        // Recupera los datos de la sesión
        $user = Session::get('googleUser');

        return view('auth.register', compact('tiposDoc', 'user'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Crear el usuario en la tabla usuarios
        $user = User::create([
            'num_doc' => $request->num_doc,
            't_doc' => $request->t_doc,
            'usu_nombres' => $request->usu_nombres,
            'usu_apellidos' => $request->usu_apellidos ?? " ",
            'email' => $request->usu_email,
            'usu_fecha_nacimiento' => $request->usu_fecha_nacimiento,
            'usu_sexo' => $request->usu_sexo,
            'usu_direccion' => $request->usu_direccion,
            'usu_telefono' => $request->usu_telefono,
            'usu_estado' => $request->usu_estado,
            'usu_fecha_contratacion' => now(), // Asignar la fecha de contratación actual
            'imag_perfil' => $request->imag_perfil,
            'external_id' => $request->external_id,
            'external_auth' => 'google'
        ]);

        if (!$request->external_id) {
            // Crear el registro en la tabla seguridad
            Seguridad::create([
                'usu_num_doc' => $request->num_doc,
                'seg_clave_hash' => Hash::make($request->password),
            ]);
        }

        event(new Registered($user));

        Auth::login($user); // Iniciar sesión automáticamente después del registro

        return redirect(route('dashboard', absolute: false));
    }
}
