<?php
require_once "../conexion.php";

// Importar PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
//use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $telefono = $_POST['telefono'] ?? '';
    $email = $_POST['email'] ?? '';
    $fecha = $_POST['fecha'] ?? '';
    $hora = $_POST['hora'] ?? '';
    $servicios = $_POST['servicios'] ?? '';
    $total = $_POST['total'] ?? 0;

    //preparar la consulta
    $stmt = $mysqli->prepare("INSERT INTO turnos (nombre_cliente, telefono_cliente, email_cliente, fecha_turno, hora_turno, servicios, total) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssd", $nombre, $telefono, $email, $fecha, $hora, $servicios, $total);

    if ($stmt->execute()) {
        echo "<h2>Turno confirmado</h2>";
        echo "<p><strong>Nombre:</strong> $nombre</p>";
        echo "<p><strong>Teléfono:</strong> $telefono</p>";
        echo "<p><strong>Email:</strong> $email</p>";
        echo "<p><strong>Fecha:</strong> $fecha</p>";
        echo "<p><strong>Hora:</strong> $hora</p>";
        echo "<p><strong>Servicios:</strong> $servicios</p>";
        echo "<p><strong>Total:</strong> $$total</p>";

 // ---------- envio del correo con PHPMailer ----------
        $mail = new PHPMailer(true);

        try {
            // Config SMTP
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';  // Servidor SMTP de Gmail
            $mail->SMTPAuth   = true;
            $mail->Username   = 'cecimilimart@gmail.com'; // Tu email
            $mail->Password   = 'nslg flne iydr adds';   // Contraseña de app si usas Gmail
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            // Destinatario
            $mail->setFrom('cecimilimart@gmail.com', 'Agenda tu Look');
            $mail->addAddress($email);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Confirmacion de turno';
            $mail->Body    = "
                <p>Hola <strong>$nombre</strong>,</p>
                <p>Tu turno fue confirmado correctamente!</p>
                <p>Fecha: $fecha</p>
                <p>Hora: $hora</p>
                <p>Servicios: $servicios</p>
                <p>Total: $$total</p>
                <p>¡Te esperamos!</p>
            ";

            $mail->send();
            echo "<p>Correo de confirmacion enviado a <strong>$email</strong>.</p>";
        } catch (Exception $e) {
            echo "<p><strong> No se pudo enviar el correo:</strong> {$mail->ErrorInfo}</p>";
        }

    } else {
        echo "<h2>Error al guardar el turno </h2>";
        echo "<p>" . $mysqli->error . "</p>";
    }

    $stmt->close();
}