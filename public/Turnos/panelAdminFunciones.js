function formatearFecha(fechaISO) {
  const partes = fechaISO.split("-");
  return `${partes[2]}/${partes[1]}/${partes[0]}`;
}
let tablaVisible = false;

function mostrarTurnos() {
  const tabla = document.getElementById("tablaTurnos");

  fetch("acciones.php?accion=listar_turnos")
    .then(res => res.json())
    .then(data => {
      if (!tabla) {
        console.error("No se encontró el contenedor #tablaTurnos");
        return;
      }

      if (data.length === 0) {
        tabla.innerHTML = "<p>No hay turnos agendados.</p>";
      } else {
        tabla.innerHTML = "<table><tr><th>Fecha</th><th>Hora</th><th>Cliente</th><th>Servicios</th><th>Total</th><th>Acciones</th></tr>" +
          data.map(turno => `
            <tr>
              <td>${formatearFecha(turno.fecha_turno)}</td>
              <td>${turno.hora_turno}</td>
              <td>${turno.nombre_cliente}</td>
              <td>${turno.servicios}</td>
              <td>$${turno.total}</td>
              <td>
                <button onclick="cancelarTurno(${turno.id})">Cancelar</button>
              </td>
            </tr>
          `).join("") + "</table>";
      }

      tablaVisible = true;
    })
    .catch(error => {
      console.error("Error al cargar los turnos:", error);
      tabla.innerHTML = "<p>Error al cargar los turnos.</p>";
    });
}

function ocultarTurnos() {
  const tabla = document.getElementById("tablaTurnos");
  if (tabla) tabla.innerHTML = "";
  tablaVisible = false;
}

function toggleTurnos() {
  const contenedor = document.getElementById("turnosContainer");

  if (tablaVisible) {
    contenedor.style.display = "none";
    ocultarTurnos();
  } else {
    contenedor.style.display = "block";
    mostrarTurnos();
  }
}
function cancelarTurno(id) {
  if (confirm("¿Estás segura de cancelar este turno?")) {
    fetch(`acciones.php?accion=cancelar_turno&id=${id}`)
      .then(res => res.text())
      .then(msg => {
        alert(msg);
        mostrarTurnos(true); // recarga sin cerrar
      })
      .catch(error => {
        console.error("Error al cancelar el turno:", error);
        alert("Error al cancelar el turno.");
      });
  }
}

let serviciosVisible = false;

function mostrarServicios(forzar = false) {
  const contenedor = document.getElementById("serviciosContainer");

  if (serviciosVisible && !forzar) {
    contenedor.innerHTML = "";
    serviciosVisible = false;
    return;
  }

  fetch("acciones.php?accion=ver_servicios")
    .then(res => res.json())
    .then(data => {
      let html = `
        <table>
          <tr><th>Nombre</th><th>Precio</th><th>Acciones</th></tr>
          ${data.map(s => `
            <tr>
              <td id="nombre-${s.id}">${s.nombre}</td>
              <td id="precio-${s.id}">$${s.precio}</td>
              <td id="acciones-${s.id}">
                <button onclick="activarEdicion(${s.id}, '${s.nombre.replace(/'/g, "\\'")}', ${s.precio})">Editar</button>
                <button onclick="eliminarServicio(${s.id})">Eliminar</button>
              </td>
            </tr>
          `).join("")}
        </table>

        <h3>Agregar nuevo servicio</h3>
        <input type="text" id="nuevoNombre" placeholder="Nombre">
        <input type="number" id="nuevoPrecio" placeholder="Precio">
        <button onclick="agregarServicio()">Agregar</button>
      `;

      contenedor.innerHTML = html;
      serviciosVisible = true;
    })
    .catch(error => {
      console.error("Error al cargar servicios:", error);
      contenedor.innerHTML = "<p>Error al cargar los servicios.</p>";
      serviciosVisible = true;
    });
}

function activarEdicion(id, nombre, precio) {
  document.getElementById(`nombre-${id}`).innerHTML = `<input type="text" value="${nombre}" id="edit-nombre-${id}">`;
  document.getElementById(`precio-${id}`).innerHTML = `<input type="number" value="${precio}" id="edit-precio-${id}">`;

  document.getElementById(`acciones-${id}`).innerHTML = `
    <button onclick="guardarServicio(${id})">Guardar</button>
    <button onclick="mostrarServicios()">Cancelar</button>
  `;
}

function guardarServicio(id) {
  const nombre = document.getElementById(`edit-nombre-${id}`).value;
  const precio = document.getElementById(`edit-precio-${id}`).value;

  if (!nombre || !precio) {
    alert("Completá ambos campos");
    return;
  }

  fetch(`acciones.php?accion=editar_servicio&id=${id}&nombre=${encodeURIComponent(nombre)}&precio=${precio}`)
    .then(res => res.text())
    .then(msg => {
      alert(msg);
      mostrarServicios(true);
    })
    .catch(error => {
      console.error("Error al guardar servicio:", error);
      alert("Hubo un problema al guardar el servicio.");
    });
}

function eliminarServicio(id) {
  if (!confirm("¿Eliminar este servicio?")) return;

  fetch(`acciones.php?accion=eliminar_servicio&id=${id}`)
    .then(res => res.text())
    .then(msg => {
      alert(msg);
      mostrarServicios(true);
    })
    .catch(error => {
      console.error("Error al eliminar servicio:", error);
      alert("Hubo un problema al eliminar el servicio.");
    });
}

function agregarServicio() {
  const nombre = document.getElementById("nuevoNombre").value;
  const precio = document.getElementById("nuevoPrecio").value;

  if (!nombre || !precio) {
    alert("Completá ambos campos");
    return;
  }

  fetch(`acciones.php?accion=agregar_servicio&nombre=${encodeURIComponent(nombre)}&precio=${precio}`)
    .then(res => res.text())
    .then(msg => {
      alert(msg);
      mostrarServicios(true);
    })
    .catch(error => {
      console.error("Error al agregar servicio:", error);
      alert("Hubo un problema al agregar el servicio.");
    });
}
function filtrarPorFecha() {
  const fecha = document.getElementById("filtroFecha").value;
  const tabla = document.getElementById("tablaTurnos");

  if (!fecha) {
    alert("Seleccioná una fecha para filtrar.");
    return;
  }

  fetch(`acciones.php?accion=filtrar_turnos_por_fecha&fecha=${fecha}`)
    .then(res => res.json())
    .then(data => {
      if (data.length === 0) {
        tabla.innerHTML = "<p>No hay turnos para esa fecha.</p>";
      } else {
        tabla.innerHTML = "<table><tr><th>Fecha</th><th>Hora</th><th>Cliente</th><th>Servicios</th><th>Total</th><th>Acciones</th></tr>" +
          data.map(turno => `
            <tr>
              <td>${formatearFecha(turno.fecha_turno)}</td>
              <td>${turno.hora_turno}</td>
              <td>${turno.nombre_cliente}</td>
              <td>${turno.servicios}</td>
              <td>$${turno.total}</td>
              <td>
                <button onclick="cancelarTurno(${turno.id})">Cancelar</button>
              </td>
            </tr>
          `).join("") + "</table>";
      }
    })
    .catch(error => {
      console.error("Error al filtrar turnos:", error);
      tabla.innerHTML = "<p>Error al filtrar los turnos.</p>";
    });
}
