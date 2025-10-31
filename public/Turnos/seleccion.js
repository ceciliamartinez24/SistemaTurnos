// Formatear fecha estilo argentino
function formatearFecha(fechaISO) {
  const partes = fechaISO.split("-");
  return `${partes[2]}/${partes[1]}/${partes[0]}`;
}

// Función para avanzar entre pasos
function mostrarPasos(actual, siguiente) {
  document.getElementById(actual).style.display = "none";
  document.getElementById(siguiente).style.display = "block";
}

// Paso 1 → Paso 2: validar datos del cliente
document.getElementById("botonSiguiente1").addEventListener("click", () => {
  const nombre = document.getElementById("nombreCliente").value.trim();
  const telefono = document.getElementById("telefonoCliente").value.trim();
  const email = document.getElementById("emailCliente").value.trim();

  if (!nombre || !telefono || !email) {
    alert("Por favor complete sus datos");
    return;
  }

  document.getElementById("nombreResumen").textContent = nombre;
  document.getElementById("telefonoResumen").textContent = telefono;
  document.getElementById("emailResumen").textContent = email;
  document.getElementById("nombreHidden").value = nombre;
  document.getElementById("telefonoHidden").value = telefono;
  document.getElementById("emailHidden").value = email;

  mostrarPasos("solicitudTurno", "seleccionarFecha");
});

// Validar horarios al seleccionar fecha
document.getElementById("fechaTurno").addEventListener("change", function () {
  const fecha = this.value;
  if (!fecha) return;

  fetch(`acciones.php?accion=horarios_disponibles&fecha=${fecha}`)
    .then(res => res.json())
    .then(data => {
      const selector = document.getElementById("horaTurno");
      const opciones = selector.querySelectorAll("option");

      opciones.forEach(opcion => {
        const hora = opcion.value;
        if (!hora) return;

        const cantidad = data[hora] || 0;
        const disponible = cantidad < 2;

        opcion.disabled = !disponible;
        opcion.textContent = disponible ? hora : `${hora} (no disponible)`;
      });
    })
    .catch(error => {
      console.error("Error al cargar disponibilidad de horarios:", error);
    });
});

// Paso 2 → Paso 3: validar disponibilidad en tiempo real
document.getElementById("botonSiguiente2").addEventListener("click", () => {
  const fecha = document.getElementById("fechaTurno").value;
  const hora = document.getElementById("horaTurno").value;

  if (!fecha || !hora) {
    alert("Seleccione fecha y hora.");
    return;
  }

  fetch(`acciones.php?accion=horarios_disponibles&fecha=${fecha}`)
    .then(res => res.json())
    .then(data => {
      const cantidad = data[hora] || 0;

      if (cantidad >= 2) {
        alert("Este horario ya tiene dos turnos agendados. Elegí otro.");
        return;
      }

      const fechaFormateada = formatearFecha(fecha);
      document.getElementById("fechaSeleccionada").textContent = fechaFormateada;
      document.getElementById("horaSeleccionada").textContent = hora;
      document.getElementById("fechaHidden").value = fecha;
      document.getElementById("horaHidden").value = hora;

      mostrarPasos("seleccionarFecha", "flyerServicios");
    })
    .catch(error => {
      console.error("Error al validar disponibilidad:", error);
      alert("Error al validar el horario. Intentá de nuevo.");
    });
});

// Paso 3 → Paso 4: resumen de servicios
document.getElementById("botonSiguiente3").addEventListener("click", () => {
  let servicios = document.querySelectorAll(".servicios:checked");
  let listaServicios = document.getElementById("listaServicios");
  let total = 0;
  let nombreServicios = [];

  listaServicios.innerHTML = "";

  servicios.forEach(s => {
    let li = document.createElement("li");
    li.textContent = `${s.value} - $${s.dataset.precio}`;
    listaServicios.appendChild(li);
    total += parseInt(s.dataset.precio);
    nombreServicios.push(s.value);
  });

  document.getElementById("total").textContent = total;
  document.getElementById("serviciosHidden").value = nombreServicios.join(",");
  document.getElementById("totalHidden").value = total;

  mostrarPasos("flyerServicios", "resumenTurno");
});

// Botón administrador
document.getElementById("botonAdministrador").addEventListener("click", function () {
  window.location.href = "login.php";
});

// Cargar servicios dinámicamente
function cargarServicios() {
  fetch("acciones.php?accion=ver_servicios")
    .then(res => res.json())
    .then(data => {
      const lista = document.getElementById("listaCheckboxServicios");
      lista.innerHTML = "";

      data.forEach(servicio => {
        lista.innerHTML += `
          <label>
            <input type="checkbox" class="servicios" data-precio="${servicio.precio}" value="${servicio.nombre}">
            ${servicio.nombre} ($${servicio.precio})
          </label><br>
        `;
      });
    })
    .catch(error => {
      console.error("Error al cargar servicios:", error);
    });
}
cargarServicios();