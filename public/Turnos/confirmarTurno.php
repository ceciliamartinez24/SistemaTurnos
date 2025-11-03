<?php
require_once "../conexion.php";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

// --- DATOS DEL FORMULARIO ---
$fecha = $_POST['fecha'] ?? '';
$hora = $_POST['hora'] ?? '';

$stmt = $mysqli->prepare("SELECT COUNT(*) FROM turnos WHERE fecha_turno = ? AND hora_turno = ?");
$stmt->bind_param("ss", $fecha, $hora);
$stmt->execute();
$stmt->bind_result($cantidad);
$stmt->fetch();
$stmt->close();

if ($cantidad >= 2) {
  echo "<script>alert('Este horario ya tiene dos turnos agendados. Elegí otro.'); window.history.back();</script>";
  exit;
}

$nombre = $_POST['nombre'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$email = $_POST['email'] ?? '';
$servicios = $_POST['servicios'] ?? '';
$total = $_POST['total'] ?? 0;

// --- GUARDAR EN BASE DE DATOS ---
$stmt = $mysqli->prepare("INSERT INTO turnos (nombre_cliente, telefono_cliente, email_cliente, fecha_turno, hora_turno, servicios, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssd", $nombre, $telefono, $email, $fecha, $hora, $servicios, $total);

if ($stmt->execute()) {

  // --- ENVIAR MAIL ---
  $mail = new PHPMailer(true);
  try {
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'cecimilimart@gmail.com';
    $mail->Password = 'nslg flne iydr adds';
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom('cecimilimart@gmail.com', 'Agenda tu Look');
    $mail->addAddress($email);
    $mail->isHTML(true);
    $mail->Subject = 'Confirmacion de turno';
    $mail->Body = "
      <p>Hola <strong>$nombre</strong>,</p>
      <p>Tu turno fue confirmado correctamente!</p>
      <p><strong>Fecha:</strong> $fecha</p>
      <p><strong>Hora:</strong> $hora</p>
      <p><strong>Servicios:</strong> $servicios</p>
      <p><strong>Total:</strong> $$total</p>
      <p>¡Te esperamos!</p>
    ";

    $mail->send();

    // --- MOSTRAR PANTALLA DE EXITO ---
    echo '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Turno confirmado</title>
       <link rel="stylesheet" href="css/estilosTurnoConfirmado.css">
    </head>
    <body>
        <div class="card">
            <h1>Turno confirmado</h1>
            <p>El turno fue agendado y el correo se envió exitosamente.</p>
            <a href="index.php">Volver al inicio</a>
        </div>
    </body>
    </html>';
    exit;

  } catch (Exception $e) {
    // --- SI EL MAIL FALLA ---
    echo '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Error al enviar</title>
        <link rel="stylesheet" href="css/estilosTurnoConfirmado.css">
    </head>
    <body>
        <div class="card">
            <h1>No se pudo enviar el correo</h1>
            <p>El turno se guardo correctamente, pero el email no pudo enviarse.</p>
            <a href="index.php">Volver al inicio</a>
        </div>
    </body>
    </html>';
    exit;
  }

} else {
  echo "Error al guardar el turno en la base de datos.";
}
?>
