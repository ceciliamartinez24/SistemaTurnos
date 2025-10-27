<?php
session_start();
session_destroy();
header("Location: Turnos/login.php"); // Ajustá la ruta si tu login está en otra carpeta
exit();