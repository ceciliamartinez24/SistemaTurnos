<?php
// logout.php — Cierra la sesión activa del administrador.
// Redirige al login y elimina variables de sesión.
session_start();
session_destroy();
header("Location: Turnos/login.php"); 
exit();