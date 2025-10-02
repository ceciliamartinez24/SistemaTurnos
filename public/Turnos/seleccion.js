// Función para formatear fecha estilo argentino
  function formatearFecha(fechaISO) {
    const partes = fechaISO.split("-");
    return `${partes[2]}/${partes[1]}/${partes[0]}`;
  }

  document.getElementById("boton").addEventListener("click", () => {
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

    // Capturar y mostrar la fecha formateada
    let fecha = document.getElementById("fechaTurno").value;
    if (fecha) {
      let fechaFormateada = formatearFecha(fecha);
      document.getElementById("fechaSeleccionada").textContent = fechaFormateada;
      document.getElementById("fechaTurnoSeleccionada").value = fechaFormateada;
    } else {
      document.getElementById("fechaSeleccionada").textContent = "No seleccionada";
      document.getElementById("fechaTurnoSeleccionada").value = "";
    }
    let hora = document.getElementById("horaTurno").value;
    if (hora) {
      document.getElementById("horaSeleccionada").textContent = hora;
      document.getElementById("horaTurnoSeleccionada").value = hora;
    } else {
      document.getElementById("horaSeleccionada").textContent = "No seleccionada";
      document.getElementById("horaTurnoSeleccionada").value = "";
      }

    document.getElementById("total").textContent = total;
    document.getElementById("resumenTurno").style.display = "block";

    document.getElementById("serviciosSeleccionados").value = nombreServicios.join(",");
    document.getElementById("precioTotal").value = total;
    let resumen = `Fecha: ${document.getElementById("fechaSeleccionada").textContent}
    Hora: ${document.getElementById("horaSeleccionada").textContent}
    Servicios:\n`;
    servicios.forEach(s => {
      resumen += `- ${s.value} ($${s.dataset.precio})\n`;
    });

resumen += `Total: $${total}`;

alert(resumen);


  });
  document.getElementById("botonHora").addEventListener("click", () => {
  let hora = document.getElementById("horaTurno").value;
  if (hora) {
    document.getElementById("horaSeleccionada").textContent = hora;
    document.getElementById("horaTurnoSeleccionada").value = hora;
  } else {
    document.getElementById("horaSeleccionada").textContent = "No seleccionada";
    document.getElementById("horaTurnoSeleccionada").value = "";
  }
});
  document.getElementById("botonFecha").addEventListener("click", () => {
  let fecha = document.getElementById("fechaTurno").value;
  if (fecha) {
    let fechaFormateada = formatearFecha(fecha);
    document.getElementById("fechaSeleccionada").textContent = fechaFormateada;
    document.getElementById("fechaTurnoSeleccionada").value = fechaFormateada;
  } else {
    document.getElementById("fechaSeleccionada").textContent = "No seleccionada";
    document.getElementById("fechaTurnoSeleccionada").value = "";
  }
});