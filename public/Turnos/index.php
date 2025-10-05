<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agenda tu look</title>
  <style>
   /* General */
body {
  font-family: Arial, sans-serif;
  margin: 0;
  padding: 0;
  background: #fff9f9;
}

header {
  background: #b987b5;
  color: white;
  text-align: center;
  padding: 1rem;
}

/* Layout principal */
main {
   display: flex;
  justify-content: center;
  align-items: flex-start;
  gap: 2rem;
  max-width: 1000px;
  margin: 0 auto;
  padding: 2rem;
  box-sizing: border-box;

}

/* Columna izquierda: calendario + hora */
.columnaIzquierda {
  flex: 0 0 auto;
  width: 320px;
  display: flex;
  flex-direction: column;
  gap: 2rem;

}

/* Bloques de calendario y hora */
.calendario {
  background: white;
  padding: 1rem;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);

}

.calendario h2 {
  text-align: center;
  margin-bottom: 1rem;
}

/* Columna derecha: servicios */
.flyerServicios {
  flex: 0 0 auto;
  width: 400px;
  background: white;
  padding: 1.5rem;
  border-radius: 10px;
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
  text-align: center;

}

.flyerServicios h2 {
  margin-bottom: 1rem;
}

/* Servicios */
.servicios {
  background: #f1f1f1;
  padding: 0.5rem;
  margin: 0.5rem 0;
  border-radius: 5px;
}

/* Botones */
.boton {
    display: inline-block;
  margin-top: 1rem;
  padding: 0.7rem 1.2rem;
  background: #aa6db3;
  color: white;
  text-decoration: none;
  border-radius: 5px;
  border: 2px solid white; /* ← esta línea unifica el borde */
  transition: background 0.3s;

}

.boton:hover {
  background: #9f5ea1;
  border: 2px solid white;

}
  </style>
</head>
<body>

  <header>
    <h1>Agenda tu look</h1>
  </header>

   <main>
  <!--pantalla inicial-->
  <section id="inicio">
  <h1>Bienvenido a Agenda tu look</h1>
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
    </form>
     <button type="button" id="botonSiguiente1" class="boton">Siguiente</button>
  </div>
  </section>

  <!-- paso 2: seleccionar fecha y hora -->
  <section id="seleccionarFecha" class="columnaIzquierda" style="display:none">
    <div class="calendario">
      <h2>Seleccionar fecha</h2>
      <input type="date" id="fechaTurno">
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

  <!-- paso 3: seleccion de servicios -->
  <section id="flyerServicios" class="flyerServicios" style="display:none;">
    <h2>Seleccionar servicios</h2>
    <label><input type="checkbox" class="servicios" data-precio="10000" value="Corte de pelo"> Corte de pelo ($10.000)</label><br>
    <label><input type="checkbox" class="servicios" data-precio="5000" value="Perfilado de cejas"> Perfilado de cejas ($5.000)</label><br>
    <label><input type="checkbox" class="servicios" data-precio="7000" value="Nutricion y lavado"> Nutricion y lavado ($7.000)</label><br>
    <a href="#" id="botonSiguiente3" class="boton">Solicitar turno</a>
  </section>

<!--paso 4: resumen del turno-->
  <section id="resumenTurno" style="display:none;">
  <h3>Resumen de su turno:</h3>
  <p><stong>Nombre:</stong> <span id="nombreResumen"></span></p>
  <p><stong>Telefono:</stong> <span id="telefonoResumen"></span></p>
  <p><strong>Fecha seleccionada:</strong> <span id="fechaSeleccionada"></span></p>
  <p><strong>Hora seleccionada:</strong> <span id="horaSeleccionada"></span></p>
  <p><strong>Servicios:</strong></p>
  <ul id="listaServicios"></ul>
  <p><strong>Total:</strong> $<span id="total"></span></p>

  <form action="confirmarTurno.php" method="POST">
        <input type="hidden" name="nombre" id="nombreHidden">
        <input type="hidden" name="telefono" id="telefonoHidden">
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
