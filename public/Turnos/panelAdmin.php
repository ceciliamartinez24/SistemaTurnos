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
<button onclick="toggleHorarios()">Ver horarios de atención</button>

<div id="contenedorHorarios" style="display:none; margin-top:1em;">
<div id="formularioHorario" style="margin-bottom: 1em;">
  <h3>Agregar nuevo horario</h3>
  <label>Día:
    <select id="nuevoDia">
      <option value="">-- Elegí un día --</option>
      <option value="lunes">Lunes</option>
      <option value="martes">Martes</option>
      <option value="miércoles">Miércoles</option>
      <option value="jueves">Jueves</option>
      <option value="viernes">Viernes</option>
      <option value="sábado">Sábado</option>
      <option value="domingo">Domingo</option>
    </select>
  </label>
  <label>Desde: <input type="time" id="nuevoInicio"></label>
  <label>Hasta: <input type="time" id="nuevoFin"></label>
  <button type="button" onclick="agregarHorario()">Agregar</button>
</div>

  <table id="tablaHorarios">
    <thead>
      <tr>
        <th>Día</th>
        <th>Desde</th>
        <th>Hasta</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>
</div>
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