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
    .calendar {
      width: 50%;
      background: white;
      padding: 1rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    .calendar h2 {
      text-align: center;
      margin-bottom: 1rem;
    }

    /* Flyer de servicios */
    .flyer {
      width: 35%;
      background: white;
      padding: 1rem;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
    }

    .flyer h2 {
      margin-bottom: 1rem;
    }

    .service {
      background: #f1f1f1;
      padding: 0.5rem;
      margin: 0.5rem 0;
      border-radius: 5px;
    }

    /* Botón */
    .btn {
      display: inline-block;
      margin-top: 1rem;
      padding: 0.7rem 1.2rem;
      background: #0077b6;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      transition: background 0.3s;
    }

    .btn:hover {
      background: #023e8a;
    }
  </style>
</head>
<body>

  <header>
    <h1>Sistema de Turnos</h1>
  </header>

  <main>
    <!-- Calendario -->
    <section class="calendar">
      <h2>Calendario de Turnos</h2>
      <p>Aquí se mostrarán los turnos disponibles.</p>
      <!-- Más adelante acá podemos usar un input de tipo date o un calendario dinámico -->
      <input type="date" id="fechaTurno">
      <br><br>
      <button class="btn">Seleccionar Turno</button>
    </section>

    <!-- Flyer de Servicios -->
    <section class="flyer">
      <h2>Servicios</h2>
      <div class="service">Servicio 1</div>
      <div class="service">Servicio 2</div>
      <div class="service">Servicio 3</div>
      <a href="#" class="btn">Reservar Ahora</a>
    </section>
  </main>

</body>
</html>
