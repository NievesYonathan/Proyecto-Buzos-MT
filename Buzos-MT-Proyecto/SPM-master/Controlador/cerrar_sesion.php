<?php
include('../Login-Registro/config.php');

//Reset OAuth access token
$google_client->revokeToken();

session_destroy();

header("Location:../Login-Registro/login.php");
