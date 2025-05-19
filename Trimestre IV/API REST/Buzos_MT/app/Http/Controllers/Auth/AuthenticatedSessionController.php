<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\User; 
use App\Models\TipoDoc;


class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        $tiposDoc = TipoDoc::all(); // Obtiene todos los tipos de documento
        return view('auth.login', compact('tiposDoc'));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $t_doc = $request->t_doc;
        $num_doc = $request->num_doc;
        $password = $request->password;

        $usuario = User::where('t_doc', $t_doc)->where('num_doc', $num_doc)->first();

        if (!$usuario) {
            return back()->withErrors([
                'num_doc' => 'El número de documento o el tipo de documento son incorrectos.',
            ]);
        }

        // Obtener el hash de la contraseña
        $hashedPassword = $usuario->seguridad->seg_clave_hash ?? null;

        // Si no hay hash o no usa Bcrypt, actualizamos el hash
        if (!$hashedPassword || !str_starts_with($hashedPassword, '$2y$')) {
            $newHash = Hash::make($password);
            // Actualizamos usando el ID del usuario
            $usuario->seguridad()->update([
                'seg_clave_hash' => $newHash
            ]);
            $hashedPassword = $newHash;
        }

        // Verificar la contraseña
        if (!Hash::check($password, $hashedPassword)) {
            return back()->withErrors([
                'password' => 'La contraseña es incorrecta.',
            ]);
        }

        $request->session()->regenerate();
        Auth::login($usuario);
        return redirect()->intended(route('dashboard'));
    }
    
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login')->with('loggedOut', true);
    }
}
