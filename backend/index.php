<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Agenda tu look</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background: #fff9f9ff;
    }

    header {
      background: #b987b5ff;
      color: white;
      text-align: center;
      padding: 1rem;
    }

    main {
      display: flex;
      justify-content: space-around;
      padding: 2rem;
    }

    /* Calendario */
    .calendario {
      width: 50%;
      background: white;
      padding: 1rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .calendario h2 {
      text-align: center;
      margin-bottom: 1rem;
    }

    /* Flyer de servicios */
    .flyerServicios{
      width: 35%;
      background: white;
      padding: 1rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
    }

    .flyerServicios h2 {
      margin-bottom: 1rem;
    }

    .servicios {
      background: #f1f1f1;
      padding: 0.5rem;
      margin: 0.5rem 0;
      border-radius: 5px;
    }

    /* Botón */
    .boton {
      display: inline-block;
      margin-top: 1rem;
      padding: 0.7rem 1.2rem;
      background: #aa6db3ff;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      transition: background 0.3s;
    }

    .boton:hover {
      background: #9f5ea1ff;
    }
  </style>
</head>
<body>

  <header>
    <h1>Agenda tu look</h1>
  </header>

  <main>
    <!-- Calendario -->
    <section class="calendario">
      <h2>Calendario de turnos disponibles</h2>
      <p>Aquí se mostrarán los turnos disponibles.</p>
      <!-- Más adelante acá podemos usar un input de tipo date o un calendario dinámico -->
      <input type="date" id="fechaTurno">
      <br><br>
      <button class="boton">Seleccionar fecha</button>
    </section>

    <!-- Flyer de Servicios -->
    <section class="flyerServicios">
      <h2>Seleccionar servicios</h2>
      <!--<div class="servicios">Corte de pelo</div>
      <div class="servicios">Perfilado de cejas</div>
      <div class="servicios">Nutriciaon y lavado</div> 
      <a href="#" class="boton">Reservar Ahora</a>
    </section> -->
      <div>
      <label>
        <input type="checkbox" class="servicios" data-precio="10000" value="Corte de pelo"> Corte de pelo ($10.000)
      </label><br>
      <label>
        <input type="checkbox" class="servicios" data-precio="5000" value="Perfilado de cejas"> Perfilado de cejas ($5.000)
      </label><br>
      <label>
        <input type="checkbox" class="servicios" data-precio="7000" value="Nutricion y lavado"> Nutricion y lavado ($7.000)
      </label>
      </div>
      <a href="#" id="boton" class="boton">Seleccionar</a>
  </main>

  <div id="resumenTurno" style="margin-top:20px; display:none;">
  <h3>Resumen de su turno:</h3>
  <ul id="listaServicios"></ul>
  <p><strong>Total:</strong> $<span id="total"></span></p>
  <form action="confirmarTurno.php" method="POST">
    <input type="hidden" name="servicios" id="serviciosSeleccionados">
    <input type="hidden" name="total" id="precioTotal">
    <button type="submit">Confirmar turno</button>
  </form>
  </div>

  <script>
    
    document.getElementById("boton").addEventListener("click",()=>{
      let servicios=document.querySelectorAll(".servicios:checked");
      let listaServicios=document.getElementById("listaServicios");
      let total = 0;
      let nombreServicios = [];

      listaServicios.innerHTML = ""; //para que asegure que esta limpio antes de agregar
      servicios.forEach(s => {
          let li=document.createElement("li");
          li.textContent = `${s.value} - $${s.dataset.precio}`;
          listaServicios.appendChild(li);

          total += parseInt (s.dataset.precio);
      })

      document.getElementById("total").textContent = total;
      document.getElementById("resumenTurno").style.display = "block";

      document.getElementById("serviciosSeleccionados").value = nombreServicios.join(",");
      document.getElementById("precioTotal").value = total;

    })

  </script>

</body>
</html>
