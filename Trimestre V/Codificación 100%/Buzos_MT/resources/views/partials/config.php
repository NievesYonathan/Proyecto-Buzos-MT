<?php

//start session on web page
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

// Cargar las variables de entorno desde el archivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
$dotenv->load();

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$googleClientId = $_ENV['GOOGLE_CLIENT_ID'];
$google_client->setClientId($googleClientId);

//Set the OAuth 2.0 Client Secret key
$googleClientSecret = $_ENV['GOOGLE_CLIENT_SECRET'];
$google_client->setClientSecret($googleClientSecret);

//Set the OAuth 2.0 Redirect URI
$google_client->setRedirectUri('http://localhost/Proyectos/Proyecto-Buzos-MT/Buzos-MT-Proyecto/SPM-master/Controlador/ControladorUsuario.php');

// to get the email and profile 
$google_client->addScope('email');

$google_client->addScope('profile');
