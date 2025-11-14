<?php
//Establece la conexion con la base de datos sistema_turnos usando mysqli.
// Configura charset utf8mb4 y valida errores de conexion.
$host = '127.0.0.1';
$user = 'root';
$pass = ''; 
$db   = 'sistema_turnos';

$mysqli = new mysqli($host, $user, $pass, $db);

if ($mysqli->connect_error) {
    error_log('Error de conexión (' . $mysqli->connect_errno . '): ' . $mysqli->connect_error);
    die('No se pudo conectar a la base de datos.');
}

$mysqli->set_charset('utf8mb4');