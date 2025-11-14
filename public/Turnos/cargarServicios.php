<?php
//Devuelve la lista de servicios disponibles en formato JSON.
// Usado por el cliente para mostrar opciones al agendar un turno.
session_start();
if (!isset($_SESSION['admin'])) {
  http_response_code(403);
  exit('Acceso denegado');
}
include '../conexion.php';

$query = "SELECT * FROM servicios ORDER BY nombre";
$result = $mysqli->query($query);

$servicios = [];
while ($row = $result->fetch_assoc()) {
  $servicios[] = $row;
}

header('Content-Type: application/json');
echo json_encode($servicios);