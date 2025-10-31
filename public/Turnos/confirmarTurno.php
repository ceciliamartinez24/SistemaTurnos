<?php
require_once "../conexion.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

//header('Content-Type: application/json');

$response = ['status' => 'error', 'message' => 'Error desconocido'];

$fecha = $_POST['fecha'] ?? '';
$hora = $_POST['hora'] ?? '';

$stmt = $mysqli->prepare("SELECT COUNT(*) FROM turnos WHERE fecha_turno = ? AND hora_turno = ?");
$stmt->bind_param("ss", $fecha, $hora);
$stmt->execute();
$stmt->bind_result($cantidad);
$stmt->fetch();
$stmt->close();

if ($cantidad >= 2) {
  $response['message'] = 'Este horario ya tiene dos turnos agendados. Elegí otro.';
  echo json_encode($response);
  exit;
}

$nombre = $_POST['nombre'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$email = $_POST['email'] ?? '';
$servicios = $_POST['servicios'] ?? '';
$total = $_POST['total'] ?? 0;

$stmt = $mysqli->prepare("INSERT INTO turnos (nombre_cliente, telefono_cliente, email_cliente, fecha_turno, hora_turno, servicios, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssd", $nombre, $telefono, $email, $fecha, $hora, $servicios, $total);

if ($stmt->execute()) {
  // Enviar correo
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
    $mail->Subject = 'Confirmación de turno';
    $mail->Body = "
      <p>Hola <strong>$nombre</strong>,</p>
      <p>Tu turno fue confirmado correctamente!</p>
      <p>Fecha: $fecha</p>
      <p>Hora: $hora</p>
      <p>Servicios: $servicios</p>
      <p>Total: $$total</p>
      <p>¡Te esperamos!</p>
    ";
    $mail->send();

    // Mostrar HTML además del JSON
    echo "<h2>Turno confirmado</h2>";
    echo "<p><strong>Nombre:</strong> $nombre</p>";
    echo "<p><strong>Teléfono:</strong> $telefono</p>";
    echo "<p><strong>Email:</strong> $email</p>";
    echo "<p><strong>Fecha:</strong> $fecha</p>";
    echo "<p><strong>Hora:</strong> $hora</p>";
    echo "<p><strong>Servicios:</strong> $servicios</p>";
    echo "<p><strong>Total:</strong> $$total</p>";

    $response['status'] = 'success';
    $response['message'] = 'Turno confirmado y correo enviado.';
  } catch (Exception $e) {
    $response['message'] = 'Turno guardado pero no se pudo enviar el correo: ' . $mail->ErrorInfo;
  }
} else {
  echo "<h2>Error al guardar el turno</h2>";
  echo "<p>" . $mysqli->error . "</p>";
  $response['message'] = 'Error al guardar el turno: ' . $mysqli->error;
}