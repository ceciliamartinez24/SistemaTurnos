<?php
$conexion = new mysqli("localhost", "root", "", "sistema_turnos");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$mensaje = "";

if (isset($_POST['registrar'])) {
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $password = $_POST['password'];

      // Verificar si el email ya existe
    $verificar = $conexion->prepare("SELECT id FROM usuarios WHERE email = ?");
    $verificar->bind_param("s", $email);
    $verificar->execute();
    $verificar->store_result();

    if ($verificar->num_rows > 0) {
        $mensaje = "<p class='mensaje-error'>Este email ya está registrado.</p>";
    } else {
        // Encriptar la contraseña
        $password_segura = password_hash($password, PASSWORD_DEFAULT);


    //conexion con la bdd
    $sql = "INSERT INTO usuarios (usuario, email, password, rol) VALUES (?, ?, ?, 'admin')";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sss", $usuario, $email, $password_segura);

    if ($stmt->execute()) {
        $mensaje = "<p class='mensaje-exito'>Administrador registrado correctamente.</p>";

    } else {
        $mensaje = "<p class='mensaje-error'>Error al registrar: " . $conexion->error . "</p>";
    }

    $stmt->close();
}
 $verificar->close();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registro de administrador</title>
  <link rel="stylesheet" href="Css/estiloRegistrar.css"> 
</head>
<body>   
<form action="registrar.php" method="POST">
    <h2>Registro de administrador</h2>
  <?php if (!empty($mensaje)) echo $mensaje; ?>
  <input type="text" name="usuario" placeholder="Usuario" required>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Contraseña" required>
  <button type="submit" name="registrar">Registrar</button>
</form>
</body>
</html>
