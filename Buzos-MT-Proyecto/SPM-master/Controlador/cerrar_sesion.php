<?php
session_start();


session_destroy();

header("Location:../Login-Registro/login.php");
