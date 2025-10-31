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

if ($_GET['accion'] === 'filtrar_turnos_por_fecha') {
  $fecha = $_GET['fecha'];
  $stmt = $mysqli->prepare("SELECT * FROM turnos WHERE fecha_turno = ? ORDER BY hora_turno ASC");
  $stmt->bind_param("s", $fecha);
  $stmt->execute();
  $resultado = $stmt->get_result();
  $turnos = $resultado->fetch_all(MYSQLI_ASSOC);
  echo json_encode($turnos);
  exit;
}

if ($accion === 'horarios_disponibles' && isset($_GET['fecha'])) {
  $fecha = $_GET['fecha'];
  $query = "SELECT hora_turno, COUNT(*) as cantidad FROM turnos WHERE fecha_turno = ? GROUP BY hora_turno";
  $stmt = $mysqli->prepare($query);
  $stmt->bind_param("s", $fecha);
  $stmt->execute();
  $resultado = $stmt->get_result();

  $horarios = [];
  while ($row = $resultado->fetch_assoc()) {
    $horarios[$row['hora_turno']] = $row['cantidad'];
  }

  header('Content-Type: application/json');
  echo json_encode($horarios);
  exit;
}
if ($accion === 'agendar_turno' && isset($_GET['fecha'], $_GET['hora'], $_GET['cliente'], $_GET['servicios'], $_GET['total'])) {
  $fecha = $_GET['fecha'];
  $hora = $_GET['hora'];

  // Validación: ¿ya hay 2 turnos en ese horario?
  $stmt = $mysqli->prepare("SELECT COUNT(*) FROM turnos WHERE fecha_turno = ? AND hora_turno = ?");
  $stmt->bind_param("ss", $fecha, $hora);
  $stmt->execute();
  $stmt->bind_result($cantidad);
  $stmt->fetch();
  $stmt->close();

  if ($cantidad >= 2) {
    echo "Horario no disponible";
    exit;
  }

  // Guardar el turno si hay disponibilidad
  $cliente = $_GET['cliente'];
  $servicios = $_GET['servicios'];
  $total = $_GET['total'];

  $stmt = $mysqli->prepare("INSERT INTO turnos (fecha_turno, hora_turno, nombre_cliente, servicios, total) VALUES (?, ?, ?, ?, ?)");
  $stmt->bind_param("ssssd", $fecha, $hora, $cliente, $servicios, $total);
  echo $stmt->execute() ? "Turno agendado correctamente" : "Error al agendar el turno";
  $stmt->close();
  exit;
}


