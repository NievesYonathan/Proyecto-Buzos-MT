<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoDoc;
use Google_Client;
use Dotenv\Dotenv;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Cargar variables de entorno
        $dotenv = Dotenv::createImmutable(base_path());
        $dotenv->load();

        // Crear el objeto de Google Client
        $google_client = new Google_Client();

        // Configurar el cliente
        $google_client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
        $google_client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
        $google_client->setRedirectUri('http://localhost/Proyectos/Proyecto-Buzos-MT/Buzos-MT-Proyecto/SPM-master/Controlador/ControladorUsuario.php');
        $google_client->addScope('email');
        $google_client->addScope('profile');
        $google_client->setPrompt('select_account');

        // Asignar datos de tipo_documento
        $tiposDocumentos = TipoDoc::all();

        return view('Login-Registro/login', compact('tiposDocumentos'), ['google_client' => $google_client]);
    }
}
