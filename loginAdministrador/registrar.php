<?php
$conexion = new mysqli("localhost", "root", "", "sistema_turnos");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if (isset($_POST['registrar'])) {
    $usuario = $_POST['usuario'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    //encrptar la contraseña
    $password_segura = password_hash($password, PASSWORD_DEFAULT);

    //conexion con la bdd
    $sql = "INSERT INTO usuarios (usuario, email, password, rol) VALUES (?, ?, ?, 'admin')";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sss", $usuario, $email, $password_segura);

    if ($stmt->execute()) {
        echo "Administrador registrado correctamente";
    } else {
        echo "Error: " . $conexion->error;
    }

    $stmt->close();
}
?>

<form action="registrar.php" method="POST">
  <input type="text" name="usuario" placeholder="Usuario" required>
  <input type="email" name="email" placeholder="Email" required>
  <input type="password" name="password" placeholder="Contraseña" required>
  <button type="submit" name="registrar">Registrar</button>
</form>
