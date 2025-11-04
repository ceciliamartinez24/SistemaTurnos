<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agenda tu look</title>
  <link rel="stylesheet" href="css/estilosTurnos.css">
  <link href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400;700&display=swap" rel="stylesheet">

</head>
<body>

  <header>
    <h1>Agenda tu look</h1>
  </header>

  <main class="contenedor-formularios">
    
    <!-- pantalla inicial -->
    <section id="inicio" class="bloque-formulario">
      
      <button id="botonAdministrador" class="boton">Ingresar como administrador</button>
      <button id="botonSolicitar" class="boton" onclick="mostrarPasos('inicio','solicitudTurno')">Solicitar un turno</button>
    </section>

    <!-- paso 1 datos del cliente -->
    <section id="solicitudTurno" class="bloque-formulario" style="display:none;">
      <h2>Ingrese sus datos</h2>
      <form id="formularioCliente">
        <label for="nombreCliente">Nombre y apellido:</label>
        <input type="text" id="nombreCliente" required>

        <label for="telefonoCliente">Número de celular:</label>
        <input type="tel" id="telefonoCliente">

        <label for="emailCliente">Correo electrónico:</label>
        <input type="email" id="emailCliente">
      </form>
      <button type="button" id="botonSiguiente1" class="boton">Siguiente</button>
    </section>

    <!-- Paso 2: Selección de fecha y hora -->
    <section id="seleccionarFecha" class="bloque-formulario" style="display:none;">
      <h2>Seleccionar fecha y hora</h2>
      <label for="fechaTurno">Fecha:</label>
      <input type="date" id="fechaTurno" name="fechaTurno" min="<?= date('Y-m-d') ?>">
      <label for="horaTurno">Hora:</label>
      <select id="horaTurno">
        <option value="">-- Elegí una hora --</option>
        
      </select>
      <button id="botonSiguiente2" class="boton">Siguiente</button>
    </section>

    <!-- Paso 3: Selección de servicios -->
    <section id="flyerServicios" class="bloque-formulario" style="display:none;">
      <h2>Seleccionar servicios</h2>
      <div id="listaCheckboxServicios"></div>
      <a href="#" id="botonSiguiente3" class="boton">Solicitar turno</a>
    </section>

    <!-- Paso 4: Resumen del turno -->
   <section id="resumenTurno" class="bloque-formulario resumen-lindo" style="display:none;">
      <h2>Resumen de su turno</h2>
      <p><strong>Nombre:</strong> <span id="nombreResumen"></span></p>
      <p><strong>Teléfono:</strong> <span id="telefonoResumen"></span></p>
      <p><strong>Email:</strong> <span id="emailResumen"></span></p>
      <p><strong>Fecha seleccionada:</strong> <span id="fechaSeleccionada"></span></p>
      <p><strong>Hora seleccionada:</strong> <span id="horaSeleccionada"></span></p>
      <p><strong>Servicios:</strong></p>
      <ul id="listaServicios"></ul>
      <p><strong>Total:</strong> $<span id="total"></span></p>

      <form action="confirmarTurno.php" method="POST">
        <input type="hidden" name="nombre" id="nombreHidden">
        <input type="hidden" name="telefono" id="telefonoHidden">
        <input type="hidden" name="email" id="emailHidden">
        <input type="hidden" name="fecha" id="fechaHidden">
        <input type="hidden" name="hora" id="horaHidden">
        <input type="hidden" name="servicios" id="serviciosHidden">
        <input type="hidden" name="total" id="totalHidden">
        <button type="submit" class="boton">Confirmar turno</button>
      </form>
    </section>

  </main>

  <script src="seleccion.js"></script>


</body>
</html>