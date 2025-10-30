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

