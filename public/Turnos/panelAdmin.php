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
  <div id="serviciosContainer" style="margin-top: 2rem;"></div>
  <div id="turnosContainer" style="display:none;">

  <div id="filtroContainer">
    <label for="filtroFecha">Filtrar por fecha:</label>
    <input type="date" id="filtroFecha">
    <button onclick="filtrarPorFecha()">Buscar</button>
    <button onclick="mostrarTurnos()">Ver todos</button>
  </div>

  <div id="tablaTurnos"></div>
</div>


 <a href="../logout.php">Cerrar sesión</a>
<script>
function mostrarTurnos() {
  document.getElementById("tablaTurnos").innerHTML = "<p>Funciona el botón</p>";
}
</script>


  <script src="panelAdminFunciones.js"></script>
</body>
</html>