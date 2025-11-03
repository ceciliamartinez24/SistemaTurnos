//para formatear fecha estilo argentino
  function formatearFecha(fechaISO) {
    const partes = fechaISO.split("-");
    return `${partes[2]}/${partes[1]}/${partes[0]}`;
  }

  //funcion para ir avanzando los pasos
  function mostrarPasos (actual, siguiente){
    document.getElementById(actual).style.display="none";
    document.getElementById(siguiente).style.display="block";
  }

  //paso 1 hacia paso 2
  document.getElementById("botonSiguiente1").addEventListener("click", () => {
  const nombre = document.getElementById("nombreCliente").value.trim();
  const telefono = document.getElementById("telefonoCliente").value.trim();
  const email = document.getElementById("emailCliente").value.trim();

if (!nombre || !telefono || !email){
  alert ("Por favor complete sus datos");
  return;
};

  document.getElementById("nombreResumen").textContent = nombre;
  document.getElementById("telefonoResumen").textContent = telefono;
  document.getElementById("emailResumen").textContent = email;
  document.getElementById("nombreHidden").value = nombre;
  document.getElementById("telefonoHidden").value = telefono;
  document.getElementById("emailHidden").value = email;

  mostrarPasos("solicitudTurno", "seleccionarFecha");
  });

  //paso 2 hacia el paso 3
  document.getElementById("botonSiguiente2").addEventListener("click", () => {
  let fecha = document.getElementById("fechaTurno").value;
  let hora = document.getElementById("horaTurno").value;

  if (!fecha || !hora) {
    alert("Seleccione fecha y hora.");
    return;
  };

  const fechaFormateada = formatearFecha(fecha);

  document.getElementById("fechaSeleccionada").textContent = fechaFormateada;
  document.getElementById("horaSeleccionada").textContent = hora;
  document.getElementById("fechaHidden").value = fecha;
  document.getElementById("horaHidden").value = hora;

  mostrarPasos("seleccionarFecha", "flyerServicios");
});

  //paso 3 hacia el paso 4
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
//boton ingresar como administrador.
document.getElementById("botonAdministrador").addEventListener("click", function() {
  window.location.href = "login.php";
  console.log("Botón administrador presionado");
});
//funcion cargar Servicios
function cargarServicios() {
  fetch("acciones.php?accion=ver_servicios")
    .then(res => res.json())
    .then(data => {
      const lista = document.getElementById("listaCheckboxServicios");
        lista.innerHTML = ""; // limpiar antes de insertar

      data.forEach(servicio => {
        const label = document.createElement("label");
        label.innerHTML = `
          <input type="checkbox" class="servicios" data-precio="${servicio.precio}" value="${servicio.nombre}">
          ${servicio.nombre} ($${servicio.precio})
        `;
      lista.innerHTML += `
  <label>
    <input type="checkbox" class="servicios" data-precio="${servicio.precio}" value="${servicio.nombre}">
    ${servicio.nombre} ($${servicio.precio})
  </label><br>
`;

      });

      //contenedor.insertBefore(lista, document.getElementById("botonSiguiente3"));
    })
    .catch(error => {
      console.error("Error al cargar servicios:", error);
    });
}
cargarServicios();

const inputFecha = document.getElementById("fechaTurno");
const selectHora = document.getElementById("horaTurno");

inputFecha.addEventListener("change", () => {
  const fechaSeleccionada = inputFecha.value;
  
  // Traemos los turnos de ese día
  fetch(`acciones.php?accion=turnos_por_dia&fecha=${fechaSeleccionada}`)
    .then(res => res.json())
    .then(turnos => {
       console.log("Turnos recibidos del servidor:", turnos);
      // Contamos cuántos turnos hay por cada hora
      const conteoHoras = {};
      turnos.forEach(hora => {
        conteoHoras[hora] = (conteoHoras[hora] || 0) + 1;
      });

      // Recorremos las opciones del select
      for (let opcion of selectHora.options) {
        const hora = opcion.value;

        // Si tiene 2 o más turnos, se desactiva
        if (conteoHoras[hora] >= 2) {
          opcion.disabled = true;
          opcion.textContent = `${hora} (ocupado)`;
          opcion.style.color = "gray";
        } else {
          opcion.disabled = false;
          opcion.textContent = hora;
          opcion.style.color = "black";
        }
      }
    })
    .catch(err => console.error("Error al obtener turnos:", err));
});


function cargarHorariosParaDia(fechaSeleccionada) {
  const diaNombre = new Date(fechaSeleccionada).toLocaleDateString('es-AR', { weekday: 'long' }).toLowerCase();

  fetch("acciones.php?accion=ver_horarios")
    .then(res => res.json())
    .then(data => {
      const horarios = data.filter(h => h.dia === diaNombre);
      const selectHora = document.getElementById("horaTurno");
      selectHora.innerHTML = '<option value="">-- Elegí una hora --</option>';

      horarios.forEach(h => {
        const inicio = parseInt(h.hora_inicio.split(":")[0]);
        const fin = parseInt(h.hora_fin.split(":")[0]);

        for (let hora = inicio; hora <= fin; hora++) {
          const horaStr = hora.toString().padStart(2, "0") + ":00";
          const option = document.createElement("option");
          option.value = horaStr;
          option.textContent = horaStr;
          selectHora.appendChild(option);
        }
      });
    });
}

document.getElementById("fechaTurno").addEventListener("change", cargarHorariosDisponibles);

async function cargarHorariosDisponibles() {
  const fecha = document.getElementById("fechaTurno").value;
  const selectHora = document.getElementById("horaTurno");

  if (!fecha) {
    selectHora.innerHTML = `<option value="">-- Elegí una hora --</option>`;
    return;
  }

  // Día de la semana en español sin tilde
  const dias = ['domingo','lunes','martes','miércoles','jueves','viernes','sábado'];
  const fechaObj = new Date(fecha + "T00:00:00");
  const diaSemana = dias[fechaObj.getDay()];

  try {
    // 1️⃣ Traer horarios del admin
    const resHorarios = await fetch("acciones.php?accion=ver_horarios");
    const todosLosHorarios = await resHorarios.json();

    const horariosDelDia = todosLosHorarios.filter(h => h.dia.toLowerCase() === diaSemana);

    if (horariosDelDia.length === 0) {
      selectHora.innerHTML = `<option value="">No hay horarios disponibles</option>`;
      return;
    }

    // 2️⃣ Traer turnos ocupados para la fecha seleccionada
    const resOcupados = await fetch(`acciones.php?accion=horarios_disponibles&fecha=${fecha}`);
    const horariosOcupados = await resOcupados.json(); // { "10:00": 2, ... }

    // 3️⃣ Crear opciones del select
    selectHora.innerHTML = `<option value="">-- Elegí una hora --</option>`;

    horariosDelDia.forEach(h => {
      const [hInicio, mInicio] = h.hora_inicio.split(":").map(Number);
      const [hFin, mFin] = h.hora_fin.split(":").map(Number);

      let hora = hInicio;
      while (hora < hFin) {
        const horaStr = hora.toString().padStart(2, "0") + ":00";
        const option = document.createElement("option");
        option.value = horaStr;
        option.textContent = horaStr;

        // Bloquear si hay 2 o más turnos en esa hora
        if (horariosOcupados[horaStr] >= 2) {
          option.disabled = true;
          option.textContent = `${horaStr} (ocupado)`;
          option.style.color = "#b0b0b0"; // gris claro
        }

        selectHora.appendChild(option);
        hora++;
      }
    });

  } catch (error) {
    console.error("Error al cargar horarios:", error);
    selectHora.innerHTML = `<option value="">Error al cargar horarios</option>`;
  }
}
