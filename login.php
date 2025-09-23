<?php
$conexion = new mysqli("localhost", "root", "", "sistema_turnos");

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

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
            echo "Bienvenido, " . $row['usuario'];
        } else {
            echo "Contraseña incorrecta";
        }
    } else {
        echo "Usuario no encontrado";
    }

    $stmt->close();
}
?>

<form action="login.php" method="POST">
  <input type="text" name="usuario" placeholder="Usuario" required>
  <input type="password" name="password" placeholder="Contraseña" required>
  <button type="submit" name="ingresar">Ingresar</button>
</form>


