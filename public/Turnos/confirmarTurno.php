<?php
require_once "../conexion.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $hora = $_POST['hora'] ?? '';
    $servicios = $_POST['servicios'] ?? '';
    $total = $_POST['total'] ?? 0;

    //preparar la consulta
    $stmt = $mysqli->prepare("INSERT INTO turnos (nombre_cliente, telefono_cliente, fecha_turno, hora_turno, servicios, total) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssd", $nombre, $telefono, $fecha, $hora, $servicios, $total);

    if ($stmt->execute()) {
        echo "<h2>Turno confirmado</h2>";
        echo "<p><strong>Nombre:</strong> $nombre</p>";
        echo "<p><strong>Teléfono:</strong> $telefono</p>";
        echo "<p><strong>Fecha:</strong> $fecha</p>";
        echo "<p><strong>Hora:</strong> $hora</p>";
        echo "<p><strong>Servicios:</strong> $servicios</p>";
        echo "<p><strong>Total:</strong> $$total</p>";
    } else {
        echo "<h2>Error al guardar el turno </h2>";
        echo "<p>" . $mysqli->error . "</p>";
    }

    $stmt->close();
}