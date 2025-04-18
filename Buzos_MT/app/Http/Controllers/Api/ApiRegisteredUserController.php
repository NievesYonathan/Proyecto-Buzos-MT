<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Seguridad; // Asegúrate de importar el modelo Seguridad
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\TipoDoc;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Validator; 

class ApiRegisteredUserController extends Controller
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

    // public function create(): JsonResponse
    // {
    //     $tiposDoc = TipoDoc::all();
    //     // $user = Session::get('googleUser');
    
    //     return response()->json([
    //         'tipos_documento' => $tiposDoc,
    //         // 'googleUser' => $user,
    //         // 'message' => 'Datos cargados correctamente',
    //     ]);
    // }
    

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function store(Request $request): JsonResponse
    {
        // Definir las reglas de validación
        $validator = Validator::make($request->all(), [
            'num_doc' => 'required|integer',
            't_doc' => 'required|integer',
            'usu_nombres' => 'required|string|max:255',
            'usu_apellidos' => 'nullable|string|max:255',
            'usu_email' => 'required|email',
            'usu_fecha_nacimiento' => 'required|date',
            'usu_sexo' => 'required|in:M,F,O',
            'usu_direccion' => 'nullable|string|max:255',
            'usu_telefono' => 'nullable|string|max:15',
            'usu_estado' => 'required|integer',
            'password' => 'required_without:external_id|min:8|confirmed',

        ]);
    
        // Verificar si la validación falla
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }
    
        // Obtener los datos validados
        $validatedData = $validator->validated();
        
    
        // Crear usuario
        $user = User::create([
            'num_doc' => $validatedData['num_doc'],
            't_doc' => $validatedData['t_doc'],
            'usu_nombres' => $validatedData['usu_nombres'],
            'usu_apellidos' => $validatedData['usu_apellidos'] ?? " ",
            'usu_email' => $validatedData['usu_email'],
            'usu_fecha_nacimiento' => $validatedData['usu_fecha_nacimiento'],
            'usu_sexo' => $validatedData['usu_sexo'],
            'usu_direccion' => $validatedData['usu_direccion'],
            'usu_telefono' => $validatedData['usu_telefono'],
            'usu_estado' => $validatedData['usu_estado'],
            'usu_fecha_contratacion' => now(),
            //'imag_perfil' => $validatedData['imag_perfil'],
            'external_id' => $request->external_id,
            'external_auth' => $request->external_id ? 'google' : null,
        ]);
    
    
        if (!$request->external_id) {
            $seguridad = Seguridad::create([
                'usu_num_doc' => $validatedData['num_doc'],
                'seg_clave_hash' => Hash::make($validatedData['password']),
            ]);
        }
    
        event(new Registered($user));
    
        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'status' => 'success',
        ]);
    }
    
}
