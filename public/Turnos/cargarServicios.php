<?php
include 'conexion.php';

$query = "SELECT * FROM servicios ORDER BY nombre";
$result = $mysqli->query($query);

$servicios = [];
while ($row = $result->fetch_assoc()) {
  $servicios[] = $row;
}

header('Content-Type: application/json');
echo json_encode($servicios);