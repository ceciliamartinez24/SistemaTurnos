<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $servicios = $_POST['servicios']; //lista de servicios
    $total = $_POST['total']; // precio total

    // aca tambien podemos hacer lo de la fecha seleccionada en el calendario
    // guardar todo en la base de datos

    echo "<h2>Turno confirmado</h2>";
    echo "<p>Servicios: $servicios</p>";
    echo "<p>Total: $$total</p>";
}