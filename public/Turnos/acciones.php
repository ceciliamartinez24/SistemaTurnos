<?php
// Diagnóstico inicial: mostrar parámetros GET
//var_dump($_GET);

// Mostrar errores en pantalla
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Conexión a la base de datos
include '../conexion.php';

// Corrección: usar 'accion' en lugar de 'action'
$accion = $_GET['accion'] ?? '';
//echo "Valor de \$accion: $accion<br>";

// Lógica según el valor de 'accion'
if ($accion === 'listar_turnos') {
    //echo "Listando turnos...<br>";
    $query = "SELECT * FROM turnos ORDER BY fecha_turno, hora_turno";
    $result = $mysqli->query($query);
    $turnos = [];
    while ($row = $result->fetch_assoc()) {
        $turnos[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode($turnos);
    exit();
}

if ($accion === 'cancelar_turno' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $query = "DELETE FROM turnos WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        echo "Turno cancelado correctamente.";
        exit();
    } else {
        echo "Error al cancelar el turno.";
    }
    $stmt->close();
}

// Otras acciones posibles
if ($accion === 'ver' && isset($_GET['id'])) {
    echo "Mostrando detalles del turno ID: " . $_GET['id'];
    // Aquí podrías agregar una consulta SELECT para mostrar el turno
}


if ($accion === 'ver_servicios') {
  $result = $mysqli->query("SELECT id, nombre, precio FROM servicios ORDER BY nombre");
  $servicios = [];
  while ($row = $result->fetch_assoc()) {
    $servicios[] = $row;
  }
  header('Content-Type: application/json');
  echo json_encode($servicios);
  exit();
}


if ($accion === 'editar_servicio' && isset($_GET['id'], $_GET['nombre'], $_GET['precio'])) {
  $stmt = $mysqli->prepare("UPDATE servicios SET nombre = ?, precio = ? WHERE id = ?");
  $stmt->bind_param("sdi", $_GET['nombre'], $_GET['precio'], $_GET['id']);
  echo $stmt->execute() ? "Servicio actualizado" : "Error al actualizar";
  $stmt->close();
  exit();
}

if ($accion === 'eliminar_servicio' && isset($_GET['id'])) {
  $stmt = $mysqli->prepare("DELETE FROM servicios WHERE id = ?");
  $stmt->bind_param("i", $_GET['id']);
  echo $stmt->execute() ? "Servicio eliminado" : "Error al eliminar";
  $stmt->close();
  exit();
}

if ($accion === 'agregar_servicio' && isset($_GET['nombre'], $_GET['precio'])) {
  $stmt = $mysqli->prepare("INSERT INTO servicios (nombre, precio) VALUES (?, ?)");
  $stmt->bind_param("sd", $_GET['nombre'], $_GET['precio']);
  echo $stmt->execute() ? "Servicio agregado" : "Error al agregar";
  $stmt->close();
  exit();
}

