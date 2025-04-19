<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Support\Facades\Validator;

class PasswordResetLinkController extends Controller{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): JsonResponse
    {
        // Validar el campo 'usu_email'
        $validator = Validator::make($request->all(), [
            'usu_email' => ['required', 'email'], // Cambiar 'usu_email' a 'email' para validación correcta
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 422);
        }

        // Intentar enviar el enlace de restablecimiento de contraseña
        $request->validate(['usu_email' => 'required|email']);

        $status = Password::broker()->sendResetLink(
            ['usu_email' => $request->usu_email]
        );

        // Responder según el estado del envío
        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'status' => 'success',
                'message' => __($status),
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => __($status),
        ], 500);
    }
}
