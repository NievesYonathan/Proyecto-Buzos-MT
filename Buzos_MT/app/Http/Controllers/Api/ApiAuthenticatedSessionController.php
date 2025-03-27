<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Asegúrate de que el modelo User esté importado
use App\Models\TipoDoc;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Validator; 
use App\Http\Requests\Auth\LoginRequest;


class ApiAuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): JsonResponse
    {
        $tiposDoc = TipoDoc::all(); // Obtiene todos los tipos de documento
        return response()->json($tiposDoc);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): JsonResponse
{
    $validator = Validator::make($request->all(), [
        't_doc' => 'required|integer',
        'num_doc' => 'required|integer|max:10',
        'password' => 'required|string|min:8',
    ]);
    // Verificar si hay errores en la validación
    if ($validator->fails()) {
        return response()->json([
            'status' => 'error',
            'message' => 'Datos incorrectos',
            'errors' => $validator->errors()
        ], 422);
    }
    // Obtiene los valores validados
    $validated = $validator->validated();
    $t_doc = $validated['t_doc'];
    $num_doc = $validated['num_doc'];
    $password = $validated['password'];


    // Busca el usuario por el tipo de documento y el número de documento
    $usuario = User::where('t_doc', $t_doc)->where('num_doc', $num_doc)->first();

    if (!$usuario) {
        return response()->json([
            'status' => 'error',
            'message' => 'El número de documento o el tipo de documento son incorrectos.'
        ], 401);
    }

    if (!Hash::check($password, $usuario->seguridad->seg_clave_hash ?? '')) {
        return response()->json([
            'status' => 'error',
            'message' => 'La contraseña es incorrecta.'
        ], 401);
    }
    
    Auth::login($usuario);

    return response()->json([
        'status' => 'success',
        'message' => 'Inicio de sesión exitoso'
    ]);
}

    
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();

        return response()->json([
            'status' => 'success',
            'message' => 'Sesión cerrada exitosamente'
        ]);
    }
}
