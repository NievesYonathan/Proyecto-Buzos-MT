<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    private $apiBase = 'http://localhost:8000/api';

    public function index()
    {
        $usuarios = Http::get("{$this->apiBase}/usuarios")->json();
        $tiposDocumentos = Http::get("{$this->apiBase}/tipos-documentos")->json();
        $estados = Http::get("{$this->apiBase}/estados")->json();

        return view('Perfil-Admin-Usuarios.user-list', compact('usuarios', 'tiposDocumentos', 'estados'));
    }

    public function create()
    {
        $tiposDocumentos = Http::get("{$this->apiBase}/tipos-documentos")->json();
        $estados = Http::get("{$this->apiBase}/estados")->json();

        return view('Perfil-Admin-Usuarios.user-new', compact('tiposDocumentos', 'estados'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'num_doc' => ['required', 'integer'],
            't_doc' => ['required', 'integer'],
            'usu_nombres' => ['required', 'string', 'max:60'],
            'usu_apellidos' => ['required', 'string', 'max:45'],
            'usu_email' => ['required', 'string', 'email', 'max:50'],
            'usu_fecha_nacimiento' => ['required', 'date'],
            'usu_sexo' => ['required', 'string', 'max:1'],
            'usu_telefono' => ['required', 'string', 'max:10'],
            'usu_direccion' => ['required', 'string', 'max:50'],
            'usu_estado' => ['required', 'integer'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->post("{$this->apiBase}/usuarios", $validatedData);

        if ($response->successful()) {
            return redirect()->route('user-list')->with('alerta', 'Usuario creado con éxito');
        }

        return redirect()->back()->with('error', 'Error al crear usuario.');
    }

    public function update(Request $request, $num_doc)
    {
        $validatedData = $request->validate([
            'usu_nombres' => ['required', 'string', 'max:60'],
            'usu_apellidos' => ['required', 'string', 'max:45'],
            'usu_email' => ['required', 'string', 'email', 'max:50'],
            'usu_fecha_nacimiento' => ['required', 'date'],
            'usu_sexo' => ['required', 'string', 'max:1'],
            'usu_telefono' => ['required', 'string', 'max:10'],
            'usu_direccion' => ['required', 'string', 'max:50'],
            'usu_estado' => ['required', 'integer'],
        ]);

        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->put("{$this->apiBase}/usuarios/{$num_doc}", $validatedData);

        if ($response->successful()) {
            return redirect()->route('user-list')->with('alerta', 'Usuario actualizado con éxito');
        }

        return redirect()->back()->with('error', 'Error al actualizar usuario.');
    }

    public function cambiarestado($num_doc)
    {
        $response = Http::withHeaders([
            'Accept' => 'application/json',
        ])->put("{$this->apiBase}/usuarios/cambiar-estado/{$num_doc}");

        if ($response->successful()) {
            return redirect()->route('user-list')->with('alerta', 'Estado del usuario cambiado con éxito');
        }

        return redirect()->back()->with('error', 'No se pudo cambiar el estado del usuario.');
    }

    public function buscar(Request $request)
    {
        $query = $request->input('query');

        $response = Http::get("{$this->apiBase}/usuarios/buscar", [
            'query' => $query
        ]);

        if ($response->successful()) {
            $usuarios = $response->json();
            return response()->json($usuarios);
        }

        return response()->json(['error' => 'Error al buscar usuarios'], 500);
    }
}
