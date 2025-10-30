<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}
include '../conexion.php';
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Administración</title>
  <link rel="stylesheet" href="css/estilosAdmin.css">
</head>
<body>
  <h1>Bienvenido, <?php echo $_SESSION['admin']; ?></h1>

<section>
  <div class="botones-panel">
    <button onclick="toggleTurnos()">Turnos agendados</button>
    <button onclick="mostrarServicios()">Servicios disponibles</button>
  </div>

  <div id="turnosContainer"></div>
  <div id="tablaTurnos"></div>
  <div id="serviciosContainer" style="margin-top: 20px;"></div>
</section>

 <a href="../logout.php">Cerrar sesión</a>
<script>
function mostrarTurnos() {
  document.getElementById("tablaTurnos").innerHTML = "<p>Funciona el botón</p>";
}
</script>


  <script src="panelAdminFunciones.js"></script>
</body>
</html>