
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agenda tu look</title>
  <link rel="stylesheet" href="Css/estilosTurnos.css">
</head>
<body>

  <header>
    <h1>Agenda tu look</h1>
  </header>

   <main>
  <!--pantalla inicial-->
  <section id="inicio">
  <h1>Bienvenido</h1>
  <button id="botonAdministrador" class="boton">Ingresar como administrador</button>
  <button id="botonSolicitar" class="boton" onclick="mostrarPasos('inicio','solicitudTurno')">Solicitar un turno</button>
  </section>

  <!--paso 1: datos del cliemte-->
  <section id="solicitudTurno" style="display:none;">
  <div class="datosCliente">
    <h2>Ingrese sus datos</h2>
    <form id="formularioCliente">
        <label>Nombre y apellido:</label>
        <input type="text" id="nombreCliente" required>
        <label>Numero de celular:</label>
        <input type="tel" id="telefonoCliente">
        <label>Correo electronico:</label>
        <input type="email" id="emailCliente">
    </form>
     <button type="button" id="botonSiguiente1" class="boton">Siguiente</button>
  </div>
  </section>

  <!-- paso 2: seleccionar fecha y hora -->
  <section id="seleccionarFecha" class="columnaIzquierda" style="display:none">
    <div class="calendario">
      <h2>Seleccionar fecha</h2>
      <input type="date" id="fechaTurno" name="fechaTurno">
      <script>
  document.addEventListener("DOMContentLoaded", function() {
    const hoy = new Date().toISOString().split("T")[0];
    document.getElementById("fechaTurno").setAttribute("min", hoy);
  });
</script>
    </div>

    <div class="calendario">
      <h2>Seleccionar hora</h2>
      <select id="horaTurno">
        <option value="">-- Elegí una hora --</option>
        <option value="09:00">09:00</option>
        <option value="10:00">10:00</option>
        <option value="11:00">11:00</option>
        <option value="12:00">12:00</option>
        <option value="13:00">13:00</option>
        <option value="16:00">16:00</option>
        <option value="17:00">17:00</option>
        <option value="18:00">18:00</option>
        <option value="19:00">19:00</option>
        <option value="20:00">20:00</option>
      </select>

      <button id="botonSiguiente2" class="boton">Siguiente</button>
    </div>
  </section>

  <!-- seleccion de servicios -->
 <section id="flyerServicios" class="flyerServicios" style="display:none;">
  <h2>Seleccionar servicios</h2>
  <div id="listaCheckboxServicios"></div>

  <a href="#" id="botonSiguiente3" class="boton">Solicitar turno</a>
</section>


<!--paso 4: resumen del turno-->
  <section id="resumenTurno" style="display:none;">
  <h3>Resumen de su turno:</h3>
  <p><stong>Nombre:</stong> <span id="nombreResumen"></span></p>
  <p><stong>Telefono:</stong> <span id="telefonoResumen"></span></p>
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
        <button type="submit">Confirmar turno</button>
      </form>
</section>
   </main>
</body>
</html>
<script src="seleccion.js"></script>
