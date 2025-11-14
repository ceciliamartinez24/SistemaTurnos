<?php
// login.php — Permite al administrador iniciar sesión en el sistema.
// Valida credenciales y crea la sesión para acceder al panel administrativo.
session_start();
$conexion = new mysqli("localhost", "root", "", "sistema_turnos");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$mensaje = '';

if (isset($_POST['ingresar'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        $row = $resultado->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['admin'] = $row['usuario'];
            header("Location: panelAdmin.php"); 
            exit();
        } else {
            $mensaje = "Contraseña incorrecta.";
        }
    } else {
        $mensaje = "Usuario no encontrado.";
    }

    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="Css/estilos.css">
</head>
<body>
  <form action="login.php" method="POST">
    <h2>Iniciar sesión</h2>
    <?php if (!empty($mensaje)) echo "<p style='color:red;'>$mensaje</p>"; ?>
    <input type="text" name="usuario" placeholder="Usuario" required>
    <input type="password" name="password" placeholder="Contraseña" required>
    <button type="submit" name="ingresar">Ingresar</button>
    <a href="registrar.php" class="boton-registro">¿No tenés cuenta? Registrate</a>
  </form>
</body>
</html>