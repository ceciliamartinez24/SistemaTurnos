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

  <main class="contenedor-formularios">
    
    <!-- Pantalla inicial -->
    <section id="inicio" class="bloque-formulario">
      <h2>Bienvenido</h2>
      <button id="botonAdministrador" class="boton">Ingresar como administrador</button>
      <button id="botonSolicitar" class="boton" onclick="mostrarPasos('inicio','solicitudTurno')">Solicitar un turno</button>
    </section>

    <!-- Paso 1: Datos del cliente -->
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
    </section>

    <!-- Paso 3: Selección de servicios -->
    <section id="flyerServicios" class="bloque-formulario" style="display:none;">
      <h2>Seleccionar servicios</h2>
      <div id="listaCheckboxServicios"></div>
      <a href="#" id="botonSiguiente3" class="boton">Solicitar turno</a>
    </section>

    <!-- Paso 4: Resumen del turno -->
    <section id="resumenTurno" class="bloque-formulario" style="display:none;">
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
  

  <script>
    fetch(formulario.action, {
  method: 'POST',
  body: datos
})
.then(response => response.json())
.then(data => {
  if (data.status === 'success') {
    alert('✅ ' + data.message);
    document.querySelectorAll('.bloque-formulario').forEach(b => b.style.display = 'none');
    document.getElementById('inicio').style.display = 'block';
  } else {
    alert('❌ ' + data.message);
  }
})
.catch(error => {
  console.error('Error al enviar el turno:', error);
  alert('❌ No se pudo enviar el turno. Intente más tarde.');
});
    document.addEventListener("DOMContentLoaded", function() {
      const hoy = new Date().toISOString().split("T")[0];
      document.getElementById("fechaTurno").setAttribute("min", hoy);
    });
  </script>
  <script src="seleccion.js"></script>


</body>
</html>