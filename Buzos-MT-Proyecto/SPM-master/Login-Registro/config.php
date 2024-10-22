<?php

//start session on web page
session_start();

//config.php

//Include Google Client Library for PHP autoload file
require_once 'vendor/autoload.php';

//Make object of Google API Client for call Google API
$google_client = new Google_Client();

//Set the OAuth 2.0 Client ID
$googleClientId = getenv('GOOGLE_CLIENT_ID');
$google_client->setClientId($googleClientId);

//Set the OAuth 2.0 Client Secret key
$googleClientSecret = getenv('GOOGLE_CLIENT_SECRET');
$google_client->setClientSecret($googleClientSecret);

//Set the OAuth 2.0 Redirect URI
$googleRedirectURI = getenv('GOOGLE_REDIRECT_URI');
$google_client->setRedirectUri($googleRedirectURI);

// to get the email and profile 
$google_client->addScope('email');

$google_client->addScope('profile');
