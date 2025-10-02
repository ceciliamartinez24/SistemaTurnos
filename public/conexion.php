<?php

$host = '127.0.0.1';
$user = 'root';
$pass = ''; 
$db   = 'sistema_turnos';

$mysqli = new mysqli($host, $user, $pass, $db);

if ($mysqli->connect_error) {
    die('Error de conexión (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
}

$mysqli->set_charset('utf8mb4');