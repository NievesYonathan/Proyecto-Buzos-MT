<?php
// app/Http/Requests/Auth/LoginRequest.php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            't_doc' => ['required', 'integer'], // Asumiendo que es un número entero
            'num_doc' => ['required', 'integer'], // Asegúrate que sea un entero
            'password' => ['required', 'string'],
        ];
    }

    public function authenticate()
    {
        // Aquí no se necesita hacer nada, la autenticación se manejará en el controlador
    }
}
