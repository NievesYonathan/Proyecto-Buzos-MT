<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use App\Models\User; // Asegúrate de que el modelo User esté importado
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
        // Obtiene el tipo y número de documento del request
        $t_doc = $request->t_doc;
        $num_doc = $request->num_doc;
        $password = $request->password;

        // Busca el usuario por el tipo de documento y el número de documento
        $usuario = User::where('t_doc', $t_doc)->where('num_doc', $num_doc)->first();

        // Verifica si el usuario existe
        if (!$usuario) {
            return back()->withErrors([
                'num_doc' => 'El número de documento o el tipo de documento son incorrectos.',
            ]);
        }

        // Verifica si la contraseña es correcta
        if (!Hash::check($password, $usuario->seguridad->seg_clave_hash ?? '')) { // Asegúrate de tener una relación 'seguridad' en tu modelo User
            return back()->withErrors([
                'password' => 'La contraseña es incorrecta.',
            ]);
        }

        // Regenerar la sesión
        $request->session()->regenerate();

        // Autenticación exitosa
        Auth::login($usuario); // Usa el objeto de usuario
<<<<<<< Updated upstream
        // Notificación de éxito con paquete mckenziearts/laravel-notify
        // notify()->success('Welcome to Laravel Notify ⚡️');
=======

        // Notificación de éxito con paquete mckenziearts/laravel-notify
        // notify()->success('Welcome to Laravel Notify ⚡️');

        // Notificación de éxito con paquete mckenziearts/laravel-notify
        // notify()->success('Welcome to Laravel Notify ⚡️');

        // Notificación de éxito con paquete mckenziearts/laravel-notify  
        //notify()->success('Welcome to Laravel Notify ⚡️');


>>>>>>> Stashed changes
        // Redirige a la ruta dashboard
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

        return redirect('/');
    }
}
