<?php
// Controlador backend que gestiona acciones del sistema
// responde en JSON para el panel administrativo.
session_start();


// Mostrar errores en pantalla
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// conexionn a la bdd
include '../conexion.php';
$accion = $_GET['accion'] ?? '';
//echo "Valor de \$accion: $accion<br>";


if ($accion === 'listar_turnos') {
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

if ($accion === 'ver' && isset($_GET['id'])) {
    echo "Mostrando detalles del turno ID: " . $_GET['id'];
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
    $horaNormalizada = substr($row['hora_turno'], 0, 5); // "10:00:00" → "10:00"
    $horarios[$horaNormalizada] = $row['cantidad'];
  }

  header('Content-Type: application/json');
  echo json_encode($horarios);
  exit;
}
if ($accion === 'agendar_turno' && isset($_GET['fecha'], $_GET['hora'], $_GET['cliente'], $_GET['servicios'], $_GET['total'])) {
  $fecha = $_GET['fecha'];
  $hora = $_GET['hora'];


  // si hay 2 turnos en el mismo horario
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

if ($accion === 'ver_horarios') {
  $result = $mysqli->query("SELECT * FROM horarios_atencion ORDER BY FIELD(dia,'lunes','martes','miércoles','jueves','viernes','sábado','domingo'), hora_inicio");
  $datos = [];
  while ($row = $result->fetch_assoc()) {
    $datos[] = $row;
  }
  header('Content-Type: application/json');
  echo json_encode($datos);
  exit();
}

if ($accion === 'eliminar_horario' && isset($_GET['id'])) {
  $stmt = $mysqli->prepare("DELETE FROM horarios_atencion WHERE id = ?");
  $stmt->bind_param("i", $_GET['id']);
  echo $stmt->execute() ? "Horario eliminado" : "Error al eliminar";
  $stmt->close();
  exit();
}

if ($accion === 'editar_horario' && isset($_GET['id'], $_GET['dia'], $_GET['inicio'], $_GET['fin'])) {
  $stmt = $mysqli->prepare("UPDATE horarios_atencion SET dia = ?, hora_inicio = ?, hora_fin = ? WHERE id = ?");
  $stmt->bind_param("sssi", $_GET['dia'], $_GET['inicio'], $_GET['fin'], $_GET['id']);
  echo $stmt->execute() ? "Horario actualizado" : "Error al actualizar";
  $stmt->close();
  exit();
}
if ($accion === 'guardar_horario' && isset($_GET['dia'], $_GET['inicio'], $_GET['fin'])) {
  $stmt = $mysqli->prepare("INSERT INTO horarios_atencion (dia, hora_inicio, hora_fin) VALUES (?, ?, ?)");
  $stmt->bind_param("sss", $_GET['dia'], $_GET['inicio'], $_GET['fin']);
  echo $stmt->execute() ? "Horario guardado" : "Error al guardar";
  $stmt->close();
  exit();
}




